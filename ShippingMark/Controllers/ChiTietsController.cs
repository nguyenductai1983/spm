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
    public class ChiTietsController : Controller
    {
       readonly private ApplicationDbContext db = new ApplicationDbContext();

        // GET: chiTiets
        public ActionResult Index(int? page)
        {
            // Lấy tất cả dữ liệu chiTiet
            var chiTietList = db.ChiTiets.OrderByDescending(i => i.ID).ToList();
            // Tính toán số dòng đã in xong (usingPrint = true)
            ViewBag.PrintedCount = chiTietList.Count(i => i.usingPrint != true);
            long totalNumSerial = chiTietList
               .Where(i => i.usingPrint != true) // Lọc các bản ghi chưa in
               .Where(i => !string.IsNullOrEmpty(i.NumSerial))
               .Select(i => long.TryParse(i.NumSerial, out long num) ? num : 0)
               .Sum();
            ViewBag.TotalNumSerial = totalNumSerial;
            // Thiết lập kích thước trang và số trang hiện tại
            int pageSize = 50; // Mặc định hiển thị 50 bản ghi trên mỗi trang
            int pageNumber = (page ?? 1); // Nếu không có tham số page, mặc định là trang 1

            // Trả về một IPagedList thay vì List thông thường
            return View(chiTietList.ToPagedList(pageNumber, pageSize));
        }

        // GET: chiTiets/Details/5
        public ActionResult Details(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            ChiTiet chiTiet = db.ChiTiets.Find(id);
            if (chiTiet == null)
            {
                return HttpNotFound();
            }
            return View(chiTiet);
        }

        // GET: chiTiets/Create
        public ActionResult Create()
        {
            return View();
        }

        // POST: chiTiets/Create
        // To protect from overposting attacks, enable the specific properties you want to bind to, for 
        // more details see https://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Create([Bind(Include = "id,REFNO,PoNo,MODEL,SIZE,NW,GW,COLOR,Type,TypeSuffix,usingPrint,StartSerial,NumSerial,LotNo,Customer,QUANTITY,COMMODITY,CustomerCode,Dai,Rong,Cao,SelectedTypeNum")] Models.ChiTiet chiTiet)
        {
            if (ModelState.IsValid)
            {
                chiTiet.usingPrint = chiTiet.usingPrint ?? false;
                chiTiet.CreatedBy = User.Identity.Name;
                chiTiet.CreatedDate = DateTime.Now;
                db.ChiTiets.Add(chiTiet);
                db.SaveChanges();
                return RedirectToAction("Index");
            }

            return View(chiTiet);
        }

        // GET: chiTiets/Edit/5
        public ActionResult Edit(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            ChiTiet chiTiet = db.ChiTiets.Find(id);
            if (chiTiet == null)
            {
                return HttpNotFound();
            }
            return View(chiTiet);
        }

        // POST: chiTiets/Edit/5
        // To protect from overposting attacks, enable the specific properties you want to bind to, for 
        // more details see https://go.microsoft.com/fwlink/?LinkId=317598.
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit([Bind(Include = "id,REFNO,PoNo,MODEL,SIZE,GW,COLOR,StartSerial,NumSerial,usingPrint,LotNo,Type,CustomerCode,TypeSuffix,Customer,QUANTITY,COMMODITY,Dai,Rong,Cao,SelectedTypeNum")] Models.ChiTiet chiTiet)
        {            if (ModelState.IsValid)
            {
                // Lấy bản ghi gốc từ database
                var existingchiTiet = db.ChiTiets.Find(chiTiet.ID);
                if (existingchiTiet == null)
                {
                    return HttpNotFound();
                }

                // Cập nhật các trường dữ liệu từ form
                existingchiTiet.REFNO = chiTiet.REFNO;
                existingchiTiet.PoNo = chiTiet.PoNo;
                existingchiTiet.MODEL = chiTiet.MODEL;
                existingchiTiet.SIZE = chiTiet.SIZE;
                existingchiTiet.NW = chiTiet.NW;
                existingchiTiet.GW = chiTiet.GW;
                existingchiTiet.COLOR = chiTiet.COLOR;
                existingchiTiet.StartSerial = chiTiet.StartSerial;
                existingchiTiet.NumSerial = chiTiet.NumSerial;
                existingchiTiet.usingPrint = chiTiet.usingPrint;
                existingchiTiet.LotNo = chiTiet.LotNo;
                existingchiTiet.Type = chiTiet.Type;
                existingchiTiet.CustomerCode = chiTiet.CustomerCode;
                existingchiTiet.TypeSuffix = chiTiet.TypeSuffix;
                existingchiTiet.Customer = chiTiet.Customer;
                existingchiTiet.QUANTITY = chiTiet.QUANTITY;
                existingchiTiet.COMMODITY = chiTiet.COMMODITY;
                existingchiTiet.Dai = chiTiet.Dai;
                existingchiTiet.Rong = chiTiet.Rong;
                existingchiTiet.Cao = chiTiet.Cao;
                existingchiTiet.SelectedTypeNum = chiTiet.SelectedTypeNum;
                // Cập nhật thông tin người thay đổi và thời gian
                existingchiTiet.LastModifiedBy = User.Identity.Name;
                existingchiTiet.LastModifiedDate = DateTime.Now;

                // Lệnh save chỉ thay đổi các trường đã cập nhật
                db.SaveChanges();
                return RedirectToAction("Index");
            }
            return View(chiTiet);
        }
        // GET: chiTiets/Delete/5
        public ActionResult Delete(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            ChiTiet chiTiet = db.ChiTiets.Find(id);
            if (chiTiet == null)
            {
                return HttpNotFound();
            }
            return View(chiTiet);
        }

        // POST: chiTiets/Delete/5
        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteConfirmed(int id)
        {
            ChiTiet chiTiet = db.ChiTiets.Find(id);
            db.ChiTiets.Remove(chiTiet);
            db.SaveChanges();
            return RedirectToAction("Index");
        }
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult ConfirmPrint(int id)
        {
            // Tìm bản ghi chiTiet bằng id
            var chiTiet = db.ChiTiets.Find(id);
            if (chiTiet == null)
            {
                return HttpNotFound();
            }

            // Cập nhật trường usingPrint
            chiTiet.usingPrint = true;

            // Ghi nhận thông tin user và thời gian cập nhật
            chiTiet.LastModifiedBy = User.Identity.Name;
            chiTiet.LastModifiedDate = DateTime.Now;

            db.Entry(chiTiet).State = EntityState.Modified;
            db.SaveChanges();

            // Chuyển hướng trở lại trang chi tiết
            if (Request.UrlReferrer != null)
            {
                return Redirect(Request.UrlReferrer.ToString());
            }

            // Nếu không có trang trước đó, chuyển hướng về trang Index
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
