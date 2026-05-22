using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.Mvc;
using System.Web.Optimization;
using System.Web.Routing;
using ShippingMark.Models;
using Microsoft.AspNet.Identity;
using Microsoft.AspNet.Identity.EntityFramework;
namespace ShippingMark
{
    public class MvcApplication : System.Web.HttpApplication
    {
        protected void Application_Start()
        {
            AreaRegistration.RegisterAllAreas();
            FilterConfig.RegisterGlobalFilters(GlobalFilters.Filters);
            RouteConfig.RegisterRoutes(RouteTable.Routes);
            BundleConfig.RegisterBundles(BundleTable.Bundles);
            // Gọi hàm để tạo Roles
            //try
            //{
                CreateRolesAndUsers();
            //}
        //    catch (Exception )
        //    {
               
        //    }
        }
        private void CreateRolesAndUsers()
        {
            ApplicationDbContext context = new ApplicationDbContext();
            var roleManager = new RoleManager<IdentityRole>(new RoleStore<IdentityRole>(context));
            var userManager = new UserManager<ApplicationUser>(new UserStore<ApplicationUser>(context));

            // Tạo Role Admin nếu chưa tồn tại
            if (!roleManager.RoleExists("Admin"))
            {
                var role = new IdentityRole();
                role.Name = "Admin";
                roleManager.Create(role);
            }

            // Tạo Role User nếu chưa tồn tại
            if (!roleManager.RoleExists("User"))
            {
                var role = new IdentityRole();
                role.Name = "User";
                roleManager.Create(role);
            }

            // Tạo một User Admin mặc định nếu chưa tồn tại
            var adminUser = userManager.FindByName("admin");
            if (adminUser == null)
            {
                var user = new ApplicationUser {
                    UserName = "admin",
                    Email = "admin@shippingmark.com",
                    FullName = "admin"
                };
                // Mật khẩu "Admin@123" thường thỏa mãn yêu cầu (có chữ hoa, số, ký tự đặc biệt)
                var result = userManager.Create(user, "Admin@123");

                if (result.Succeeded)
                {
                    userManager.AddToRole(user.Id, "Admin");
                }
                else
                {
                    // Gắn breakpoint ở đây để xem lỗi result.Errors
                    var errors = string.Join(", ", result.Errors);
                    throw new Exception("Lỗi tạo user: " + errors);
                }
            }
        }
    }
}
