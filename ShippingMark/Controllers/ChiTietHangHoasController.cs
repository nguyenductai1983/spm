using System;
using System.Collections.Generic;
using System.Data;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web;
using System.Web.Mvc;
using ShippingMark.Models;
using PagedList; // Thêm dòng này


namespace ShippingMark.Controllers
{  
    public class ChiTietHangHoasController : Controller
    {
        private readonly ApplicationDbContext db = new ApplicationDbContext();

        // GET: ChiTietHangHoas
        public ActionResult Index(int? page)
        {
            // Bước 1: Lấy toàn bộ dữ liệu cần thiết, bao gồm cả các Container liên quan.
            var chiTietListInMemory = db.ChiTietHangHoas
                                          .Include(ct => ct.ThongBaoXuatHang.KhachHang)
                                          .Include(ct => ct.Containers) // Đã thêm Include cho Containers
                                          .OrderByDescending(i => i.ID)
                                          .ToList();

            // Bước 2: Thực hiện các phép tính trên danh sách đã có trong bộ nhớ.
            ViewBag.PrintedCount = chiTietListInMemory.Count(i => i.UsingPrint != true);

            // Tính tổng số lượng từ các Container liên quan
            long totalNumSerial = chiTietListInMemory
               .Where(ct => ct.UsingPrint != true) // Lọc các chi tiết hàng hóa chưa in
               .SelectMany(ct => ct.Containers)    // "Làm phẳng" danh sách để lấy ra tất cả container
               .Select(c => long.TryParse(c.SoLuong, out long num) ? num : 0) // Chuyển SoLuong từ string sang long (nếu lỗi thì = 0)
               .Sum(); // Tính tổng

            ViewBag.TotalNumSerial = totalNumSerial;

            // Bước 3: Phân trang trên danh sách trong bộ nhớ và gửi sang View.
            int pageSize = 50;
            int pageNumber = (page ?? 1);
            return View(chiTietListInMemory.ToPagedList(pageNumber, pageSize));
        }
        // GET: ChiTietHangHoas/Edit/5
        public ActionResult Edit(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            ChiTietHangHoa chiTietHangHoa = db.ChiTietHangHoas.Find(id);
            if (chiTietHangHoa == null)
            {
                return HttpNotFound();
            }
            // Gửi danh sách ThongBaoXuatHang sang View để tạo DropDownList
            ViewBag.ThongBaoXuatHang_ID = new SelectList(db.ThongBaoXuatHangs, "ID", "SoThongBao", chiTietHangHoa.ThongBaoXuatHang_ID);
            return View(chiTietHangHoa);
        }

        // POST: ChiTietHangHoas/Edit/5
        // Để bảo vệ khỏi các cuộc tấn công đăng quá nhiều, hãy bật các thuộc tính cụ thể mà bạn muốn liên kết đến.
        // Để biết thêm chi tiết, hãy xem https://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit([Bind(Include = "ID,ThongBaoXuatHang_ID,MODEL,SIZE,NW,GW,Dai,Rong,Cao,COLOR,SelectedTypeNum,ExtendedContent,UsingPrint,LotNo,QUANTITY")] ChiTietHangHoa chiTietHangHoa)
        {
            if (ModelState.IsValid)
            {
                // Ghi nhận thông tin người dùng và thời gian chỉnh sửa
                chiTietHangHoa.LastModifiedBy = User.Identity.Name;
                chiTietHangHoa.LastModifiedDate = DateTime.Now;

                db.Entry(chiTietHangHoa).State = EntityState.Modified;
                db.SaveChanges();
                return RedirectToAction("Index");
            }
            // Nếu model không hợp lệ, gửi lại danh sách ThongBaoXuatHang cho DropDownList
            ViewBag.ThongBaoXuatHang_ID = new SelectList(db.ThongBaoXuatHangs, "ID", "SoThongBao", chiTietHangHoa.ThongBaoXuatHang_ID);
            return View(chiTietHangHoa);
        }

        // GET: ChiTietHangHoas/Details/5
        public ActionResult Details(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            ChiTietHangHoa chiTietHangHoa = db.ChiTietHangHoas.Find(id);
            if (chiTietHangHoa == null)
            {
                return HttpNotFound();
            }
            return View(chiTietHangHoa);
        }
                     // GET: ChiTietHangHoas/Delete/5
        public ActionResult Delete(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            ChiTietHangHoa chiTietHangHoa = db.ChiTietHangHoas.Find(id);
            if (chiTietHangHoa == null)
            {
                return HttpNotFound();
            }
            return View(chiTietHangHoa);
        }

        // POST: ChiTietHangHoas/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteConfirmed(int id)
        {
            ChiTietHangHoa chiTietHangHoa = db.ChiTietHangHoas.Find(id);
            db.ChiTietHangHoas.Remove(chiTietHangHoa);
            db.SaveChanges();
            return RedirectToAction("Index");
        }

        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult ConfirmPrint(int id)
        {
            var chiTiet = db.ChiTietHangHoas.Find(id);
            if (chiTiet == null)
            {
                return HttpNotFound();
            }

            chiTiet.UsingPrint = true;
            chiTiet.LastModifiedBy = User.Identity.Name;
            chiTiet.LastModifiedDate = DateTime.Now;

            db.Entry(chiTiet).State = EntityState.Modified;
            db.SaveChanges();

            if (Request.UrlReferrer != null)
            {
                return Redirect(Request.UrlReferrer.ToString());
            }

            return RedirectToAction("Index");
        }

        // Thêm action này vào file ChiTietHangHoasController.cs

        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult UpdateReprintData(int containerId, string tu, string soLuong)
        {
            // 1. Tìm container trong database bằng ID
            var containerToUpdate = db.Containers.Find(containerId);

            if (containerToUpdate == null)
            {
                return HttpNotFound();
            }

            // 2. Cập nhật các trường cần thiết
            containerToUpdate.Tu = tu;
            containerToUpdate.SoLuong = soLuong;
            // (Bạn có thể cập nhật thêm trường "Den" nếu cần)
            // containerToUpdate.Den = (int.Parse(tu) + int.Parse(soLuong) - 1).ToString();

            // 3. Lưu thay đổi vào database
            db.SaveChanges();

            // Tạo một thông báo để hiển thị cho người dùng
            TempData["Message"] = "Cập nhật thông tin in lại thành công!";

            // 4. Chuyển hướng người dùng về lại trang Details họ vừa thao tác
            // Cần có ChiTietHangHoa_ID để quay về đúng trang
            var chiTietHangHoaId = containerToUpdate.ChiTietHangHoa_ID;
            return RedirectToAction("Details", new { id = chiTietHangHoaId });
        }
        // GET: ChiTietHangHoas/UpdateReprint/5
        public ActionResult UpdateReprint(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            // 1. Lấy dữ liệu ChiTietHangHoa và các container liên quan
            var chiTiet = db.ChiTietHangHoas.Include(ct => ct.Containers).FirstOrDefault(ct => ct.ID == id);

            if (chiTiet == null)
            {
                return HttpNotFound();
            }

            // 2. Chuyển đổi dữ liệu sang ViewModel
            var viewModel = new UpdateReprintViewModel
            {
                ChiTietHangHoaId = chiTiet.ID,
                ModelName = chiTiet.MODEL,
                Containers = chiTiet.Containers.Select(c => new ContainerUpdateItem
                {
                    ContainerId = c.ID,
                    ContainerSo = c.ContainerSo,
                    Tu = c.Tu,
                    SoLuong = c.SoLuong
                }).ToList()
            };

            // 3. Trả về View mới với ViewModel
            return View(viewModel);
        }

        // POST: ChiTietHangHoas/UpdateReprint
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult UpdateReprint(UpdateReprintViewModel viewModel)
        {
            if (!ModelState.IsValid)
            {
                // Nếu có lỗi, trả về lại form với dữ liệu đã nhập
                return View(viewModel);
            }

            // 2. Lặp qua danh sách container được gửi từ form
            foreach (var item in viewModel.Containers)
            {
                // 3. Tìm container tương ứng trong database
                var containerInDb = db.Containers.Find(item.ContainerId);
                if (containerInDb != null)
                {
                    // 4. Cập nhật thông tin
                    containerInDb.Tu = item.Tu;
                    containerInDb.SoLuong = item.SoLuong;
                }
            }

            // 5. Lưu tất cả thay đổi vào database một lần
            db.SaveChanges();

            // 6. Gửi thông báo thành công và quay về trang Index
            TempData["Message"] = "Cập nhật thông tin in lại thành công!";
            return RedirectToAction("Index");
        }
        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                db.Dispose();
            }
            base.Dispose(disposing);
        }
    }
}

