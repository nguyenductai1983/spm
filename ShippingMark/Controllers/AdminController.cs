using System;
using System.Linq;
using System.Web.Mvc;
using Microsoft.AspNet.Identity;
using Microsoft.AspNet.Identity.EntityFramework;
using ShippingMark.Models;
using System.Threading.Tasks; // Cần thiết cho các hàm bất đồng bộ

[Authorize(Roles = "Admin")]
public class AdminController : Controller
{
    private readonly ApplicationDbContext db = new ApplicationDbContext();

    // GET: Admin/UserList
    public ActionResult UserList()
    {
        var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(db));
        var users = db.Users.ToList();

        var userListViewModel = users.Select(u => new UserViewModel
        {
            Id = u.Id,
            UserName = u.UserName,
            Email = u.Email,
            Roles = userManager.GetRoles(u.Id)
        }).ToList();

        return View(userListViewModel);
    }
    // GET: Admin/SetUserRole
    public ActionResult SetUserRole(string userId)
    {
        var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(db));
        var user = userManager.FindById(userId);
        if (user == null)
        {
            return HttpNotFound();
        }

        var allRoles = db.Roles.ToList();
        ViewBag.Roles = allRoles.Select(r => new SelectListItem
        {
            Value = r.Name,
            Text = r.Name,
            Selected = userManager.IsInRole(userId, r.Name)
        });

        return View(user);
    }

    // POST: Admin/SetUserRole
    [HttpPost]
    [ValidateAntiForgeryToken]
    public ActionResult SetUserRole(string userId, string roleName)
    {
        var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(db));
        var user = userManager.FindById(userId);
        if (user == null)
        {
            return HttpNotFound();
        }

        // Xóa tất cả quyền cũ và thêm quyền mới
        userManager.RemoveFromRoles(userId, userManager.GetRoles(userId).ToArray());
        userManager.AddToRole(userId, roleName);

        return RedirectToAction("UserList");
    }
    // GET: Admin/ChangePasswordForUser
    // GET: Admin/ChangePasswordForUser
    public ActionResult ChangePasswordForUser(string userId)
    {
        var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(db));
        var user = userManager.FindById(userId);
        if (user == null)
        {
            return HttpNotFound();
        }

        ViewBag.UserName = user.UserName;
        // Sử dụng lớp ViewModel mới
        var model = new AdminChangePasswordViewModel { UserId = userId };
        return View(model);
    }

    // POST: Admin/ChangePasswordForUser
    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<ActionResult> ChangePasswordForUser(AdminChangePasswordViewModel model)
    {
        if (!ModelState.IsValid)
        {
            ViewBag.UserName = (await new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(db)).FindByIdAsync(model.UserId)).UserName;
            return View(model);
        }

        var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(db));
        var user = await userManager.FindByIdAsync(model.UserId);
        if (user == null)
        {
            return HttpNotFound();
        }

        // Xóa mật khẩu cũ và thêm mật khẩu mới
        var result = await userManager.RemovePasswordAsync(model.UserId);
        if (result.Succeeded)
        {
            result = await userManager.AddPasswordAsync(model.UserId, model.NewPassword);
            if (result.Succeeded)
            {
                return RedirectToAction("UserList");
            }
        }

        ModelState.AddModelError("", result.Errors.FirstOrDefault());
        ViewBag.UserName = user.UserName;
        return View(model);
    }
    // GET: Admin/CreateUser
    public ActionResult CreateUser()
    {
        var roleManager = new RoleManager<IdentityRole>(new RoleStore<IdentityRole>(db));
        ViewBag.selectedRole = new SelectList(roleManager.Roles.ToList(), "Name", "Name");

        var model = new AdminRegisterViewModel();
        return View(model);
    }

    // POST: Admin/CreateUser
    [HttpPost]
    [ValidateAntiForgeryToken]
    public async Task<ActionResult> CreateUser(AdminRegisterViewModel model, string selectedRole)
    {
        if (ModelState.IsValid)
        {
            var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(db));
            var user = new ApplicationUser
            {
                UserName = model.UserName,
                Email = model.Email,
                FullName = model.FullName // <-- THÊM DÒNG NÀY
            };

            try
            {
                // Tạo người dùng với mật khẩu từ form
                var result = await userManager.CreateAsync(user, model.Password);

                if (result.Succeeded)
                {
                    await userManager.AddToRoleAsync(user.Id, selectedRole);
                    return RedirectToAction("UserList");
                }
                AddErrors(result);
            }
            catch (System.Data.Entity.Validation.DbEntityValidationException ex)
            {
                // Bắt lỗi và xem chi tiết
                var sb = new System.Text.StringBuilder();
                foreach (var validationErrors in ex.EntityValidationErrors)
                {
                    foreach (var validationError in validationErrors.ValidationErrors)
                    {
                        sb.AppendLine($"Property: {validationError.PropertyName} Error: {validationError.ErrorMessage}");
                    }
                }
                // Ném ra lỗi mới với thông điệp chi tiết hơn để dễ debug
                throw new Exception(sb.ToString());
            }
        }

        ViewBag.selectedRole = new SelectList(db.Roles.ToList(), "Name", "Name", selectedRole);
        return View(model);
    }

    private void AddErrors(IdentityResult result)
    {
        foreach (var error in result.Errors)
        {
            ModelState.AddModelError("", error);
        }
    }
    // GET: Admin/DeleteUser
    public ActionResult DeleteUser(string userId)
    {
        var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(db));
        var user = userManager.FindById(userId);
        if (user == null)
        {
            return HttpNotFound();
        }
        return View(user);
    }

    // POST: Admin/DeleteUser
    [HttpPost, ActionName("DeleteUser")]
    [ValidateAntiForgeryToken]
    public async Task<ActionResult> DeleteUserConfirmed(string userId)
    {
        var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(db));
        var user = await userManager.FindByIdAsync(userId);
        if (user == null)
        {
            return HttpNotFound();
        }

        // Xóa người dùng và các vai trò, đăng nhập liên quan
        var result = await userManager.DeleteAsync(user);
        if (result.Succeeded)
        {
            return RedirectToAction("UserList");
        }

        // Nếu có lỗi, hiển thị lỗi lên trang danh sách
        ModelState.AddModelError("", result.Errors.FirstOrDefault());
        return RedirectToAction("UserList");
    }
    // Đảm bảo giải phóng tài nguyên
    protected override void Dispose(bool disposing)
    {
        if (disposing)
        {
            db.Dispose();
        }
        base.Dispose(disposing);
    }
}