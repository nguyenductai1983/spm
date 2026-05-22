using System;
using System.Data.Entity;
using System.Linq;
using System.Net;
using System.Web.Mvc;
using ShippingMark.Models;
using Rotativa;
using Microsoft.AspNet.Identity;
using System.Collections.Generic;

namespace ShippingMark.Controllers
{
    public class ThongBaoXuatHangsController : Controller
    {
        private readonly ApplicationDbContext db = new ApplicationDbContext();

        // GET: ThongBaoXuatHangs
        public ActionResult Index()
        {
            var thongBaoList = db.ThongBaoXuatHangs
                                 .Include(t => t.KhachHang)
                                 .OrderByDescending(t => t.ID)
                                 .Select(t => new ThongBaoIndexViewModel
                                 {
                                     ID = t.ID,
                                     KhachHangName = t.KhachHang.Name,
                                     PoNo = t.PoNo,
                                     REFNO = t.REFNO,
                                     Ngaydukien = t.Ngaydukien
                                 })
                                 .ToList();
            return View(thongBaoList);
        }

        // GET: ThongBaoXuatHangs/Details/5
        public ActionResult Details(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            ThongBaoXuatHang thongBaoXuatHang = GetThongBaoForReport(id);
            if (thongBaoXuatHang == null)
            {
                return HttpNotFound();
            }
            return View(thongBaoXuatHang);
        }

        // GET: ThongBaoXuatHangs/QuickCreate
        public ActionResult QuickCreate()
        {
            var viewModel = new TaoThongBaoViewModel
            {
                KhachHangList = new SelectList(db.KhachHangs.ToList(), "ID", "Name"),
                HangHoaList = new SelectList(db.HangHoas.ToList(), "ID", "Name")
            };
            return View(viewModel);
        }

        #region Create & Edit (QuickCreate Workflow)

        // POST: ThongBaoXuatHangs/QuickCreate
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult QuickCreate(TaoThongBaoViewModel viewModel)
        {
            if (ModelState.IsValid)
            {
                var thongBao = new ThongBaoXuatHang
                {
                    KhachHang_ID = viewModel.KhachHangID,
                    HangHoa_ID = viewModel.HangHoaID,
                    LoaiHang = viewModel.LoaiHang,
                    SoLuong = viewModel.SoLuong,
                    REFNO = viewModel.DonHang,
                    PoNo = viewModel.SoPO,
                    Ngaydukien = viewModel.NgayXuatHang,
                    NgayETD = viewModel.ETD,
                    CreatedById = User.Identity.GetUserId(),
                    CreatedDate = DateTime.Now
                };

                // Ánh xạ từ ViewModel sang Model
                if (viewModel.ChiTietList != null)
                {
                    foreach (var chiTietVM in viewModel.ChiTietList)
                    {
                        thongBao.ChiTietHangHoas.Add(new ChiTietHangHoa
                        {
                            MODEL = chiTietVM.MODEL,
                            SIZE = chiTietVM.SIZE,
                            NW = chiTietVM.NW,
                            GW = chiTietVM.GW,
                            Dai = chiTietVM.Dai,
                            Rong = chiTietVM.Rong,
                            Cao = chiTietVM.Cao,
                            COLOR = chiTietVM.COLOR,
                            LotNo = chiTietVM.LotNo,
                            QUANTITY = chiTietVM.QUANTITY,
                            SelectedTypeNum = chiTietVM.SelectedTypeNum,
                            ExtendedContent = chiTietVM.ExtendedContent,
                            SoLuongThamKhao = chiTietVM.SoLuongThamKhao, // <-- THÊM DÒNG NÀY
                            CreatedBy = User.Identity.GetUserId(),
                            CreatedDate = DateTime.Now
                        });
                    }
                }

                db.ThongBaoXuatHangs.Add(thongBao);
                db.SaveChanges();
                return RedirectToAction("ManageContainers", new { id = thongBao.ID });
            }
            // Nếu lỗi, nạp lại dropdown list
            viewModel.KhachHangList = new SelectList(db.KhachHangs.ToList(), "ID", "Name", viewModel.KhachHangID);
            viewModel.HangHoaList = new SelectList(db.HangHoas.ToList(), "ID", "Name", viewModel.HangHoaID);
            return View(viewModel);
        }        
        // GET: ThongBaoXuatHangs/Edit/5
        public ActionResult Edit(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            // Bạn đã Include ChiTietHangHoas ở đây là đúng rồi
            ThongBaoXuatHang thongBaoXuatHang = db.ThongBaoXuatHangs
         .Include(t => t.ChiTietHangHoas.Select(ct => ct.Containers))
         .FirstOrDefault(t => t.ID == id);
            if (thongBaoXuatHang == null)
            {
                return HttpNotFound();
            }

            var viewModel = new TaoThongBaoViewModel
            {
                ID = thongBaoXuatHang.ID,
                KhachHangID = thongBaoXuatHang.KhachHang_ID,
                HangHoaID = thongBaoXuatHang.HangHoa_ID ?? 0,
                LoaiHang = thongBaoXuatHang.LoaiHang,
                SoLuong = thongBaoXuatHang.SoLuong,
                DonHang = thongBaoXuatHang.REFNO,
                SoPO = thongBaoXuatHang.PoNo,
                NgayXuatHang = thongBaoXuatHang.Ngaydukien ?? DateTime.Now,
                ETD = thongBaoXuatHang.NgayETD ?? DateTime.Now,
                ChiTietList = thongBaoXuatHang.ChiTietHangHoas.Select(ct => new ChiTietHangHoaViewModel
                {
                    ID = ct.ID,
                    MODEL = ct.MODEL,
                    SIZE = ct.SIZE,
                    NW = ct.NW,
                    GW = ct.GW,
                    Dai = ct.Dai,
                    Rong = ct.Rong,
                    Cao = ct.Cao,
                    COLOR = ct.COLOR,
                    LotNo = ct.LotNo,
                    SelectedTypeNum = ct.SelectedTypeNum,
                    ExtendedContent = ct.ExtendedContent,
                    QUANTITY = ct.QUANTITY, // <-- THÊM DÒNG NÀY
                    SoLuongThamKhao = ct.SoLuongThamKhao, // <-- THÊM DÒNG NÀY
                    TongSoLuongTrongContainer = ct.Containers
                                  .Sum(c => long.TryParse(c.SoLuong, out long num) ? num : 0)

                }).ToList(),
                KhachHangList = new SelectList(db.KhachHangs.ToList(), "ID", "Name", thongBaoXuatHang.KhachHang_ID),
                HangHoaList = new SelectList(db.HangHoas.ToList(), "ID", "Name", thongBaoXuatHang.HangHoa_ID)
            };
            return View("QuickCreate", viewModel);
        }

        // POST: ThongBaoXuatHangs/Edit/5
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult Edit(TaoThongBaoViewModel viewModel)
        {
            // Luôn nạp lại Dropdown list ngay từ đầu để dùng trong cả trường hợp thành công và thất bại
            viewModel.KhachHangList = new SelectList(db.KhachHangs.ToList(), "ID", "Name", viewModel.KhachHangID);
            viewModel.HangHoaList = new SelectList(db.HangHoas.ToList(), "ID", "Name", viewModel.HangHoaID);

            if (ModelState.IsValid)
            {
                var thongBaoInDb = db.ThongBaoXuatHangs
                                     .Include(t => t.ChiTietHangHoas)
                                     .Include(t => t.Containers)
                                     .FirstOrDefault(t => t.ID == viewModel.ID);

                if (thongBaoInDb == null) return HttpNotFound();

                // Thực hiện logic cập nhật thông minh
                UpdateChiTietHangHoas(viewModel.ChiTietList, thongBaoInDb);

                // Kiểm tra xem logic cập nhật có thêm lỗi nào vào ModelState không
                if (!ModelState.IsValid)
                {
                    return View("QuickCreate", viewModel); // Nếu có lỗi, trả về View để hiển thị
                }

                // Nếu không có lỗi, cập nhật thông tin chính và lưu
                thongBaoInDb.KhachHang_ID = viewModel.KhachHangID;
                thongBaoInDb.HangHoa_ID = viewModel.HangHoaID;
                thongBaoInDb.LoaiHang = viewModel.LoaiHang;
                thongBaoInDb.SoLuong = viewModel.SoLuong;
                thongBaoInDb.REFNO = viewModel.DonHang;
                thongBaoInDb.PoNo = viewModel.SoPO;
                thongBaoInDb.Ngaydukien = viewModel.NgayXuatHang;
                thongBaoInDb.NgayETD = viewModel.ETD;
                thongBaoInDb.LastModifiedById = User.Identity.GetUserId();
                thongBaoInDb.LastModifiedDate = DateTime.Now;

                db.SaveChanges();
                return RedirectToAction("ManageContainers", new { id = thongBaoInDb.ID });
            }

            // Nếu ModelState ban đầu đã không hợp lệ, trả về View
            return View("QuickCreate", viewModel);
        }

        #endregion

        #region Manage Containers (Step 2)

        // GET: ThongBaoXuatHangs/ManageContainers/5
        public ActionResult ManageContainers(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }

            var thongBao = GetThongBaoForReport(id);
            if (thongBao == null)
            {
                return HttpNotFound();
            }

            var viewModel = new ManageContainersViewModel
            {
                ThongBaoInfo = new ThongBaoInfoViewModel
                {
                    ID = thongBao.ID,
                    KhachHangName = thongBao.KhachHang?.Name,
                    DanhMucName = thongBao.HangHoa?.Name,
                    SoPO = thongBao.PoNo,
                    REFNO = thongBao.REFNO
                },
                ExistingContainers = thongBao.Containers.Select(c => new ExistingContainerViewModel
                {
                    ContainerID = c.ID, // Thêm ID để tạo link Sửa/Xóa
                    ContainerSo = c.ContainerSo,
                    KichCo = c.KichCo,
                    ModelName = c.ChiTietHangHoa?.MODEL,
                    SoLuong = c.SoLuong,
                    TuDen = $"{c.Tu} - {c.Den}",
                    GhiChu = c.GhiChu
                }).ToList(),
                AddContainerForm = new AddContainerFormViewModel
                {
                    ThongBaoID = thongBao.ID,
                    AvailableModelsList = new SelectList(thongBao.ChiTietHangHoas, "ID", "MODEL")
                }
            };

            return View(viewModel);
        }

        // POST: ThongBaoXuatHangs/ManageContainers (Thêm mới)
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult ManageContainers(ManageContainersViewModel viewModel)
        {
            var form = viewModel.AddContainerForm;

            if (ModelState.IsValid)
            {
                var newContainer = new Container
                {
                    ThongBaoXuatHang_ID = form.ThongBaoID,
                    ChiTietHangHoa_ID = form.ChiTietHangHoa_ID,
                    ContainerSo = form.ContainerSo,
                    KichCo = form.KichCo,
                    SoLuong = form.SoLuong,
                    Tu = form.Tu,
                    Den = form.Den,
                    GhiChu = form.GhiChu
                };
                db.Containers.Add(newContainer);
                db.SaveChanges();
                return RedirectToAction("ManageContainers", new { id = form.ThongBaoID });
            }

            // Nếu lỗi, nạp lại toàn bộ dữ liệu
            var thongBao = GetThongBaoForReport(form.ThongBaoID);
            if (thongBao == null) return HttpNotFound();

            viewModel.ThongBaoInfo = new ThongBaoInfoViewModel { /* ... */ };
            viewModel.ExistingContainers = thongBao.Containers.Select(c => new ExistingContainerViewModel { /* ... */ }).ToList();
            viewModel.AddContainerForm.AvailableModelsList = new SelectList(thongBao.ChiTietHangHoas, "ID", "MODEL", form.ChiTietHangHoa_ID);

            return View(viewModel);
        }

        #endregion
        #region === BẮT ĐẦU CHỨC NĂNG SỬA/XÓA CONTAINER ===

        // GET: ThongBaoXuatHangs/EditContainer/10
        public ActionResult EditContainer(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Container container = db.Containers.Include(c => c.ThongBaoXuatHang.ChiTietHangHoas).FirstOrDefault(c => c.ID == id);
            if (container == null)
            {
                return HttpNotFound();
            }
            // Chuẩn bị dropdown list cho form Sửa
            ViewBag.ChiTietHangHoa_ID = new SelectList(container.ThongBaoXuatHang.ChiTietHangHoas, "ID", "MODEL", container.ChiTietHangHoa_ID);
            return View(container);
        }

        // POST: ThongBaoXuatHangs/EditContainer/10
        [HttpPost]
        [ValidateAntiForgeryToken]
        public ActionResult EditContainer(Container container)
        {
            if (ModelState.IsValid)
            {
                db.Entry(container).State = EntityState.Modified;
                db.SaveChanges();
                // Quay về trang quản lý container của phiếu cha
                return RedirectToAction("ManageContainers", new { id = container.ThongBaoXuatHang_ID });
            }
            // Nếu lỗi, nạp lại dropdown list
            var thongBao = db.ThongBaoXuatHangs.Include(t => t.ChiTietHangHoas).FirstOrDefault(t => t.ID == container.ThongBaoXuatHang_ID);
            if (thongBao != null)
            {
                ViewBag.ChiTietHangHoa_ID = new SelectList(thongBao.ChiTietHangHoas, "ID", "MODEL", container.ChiTietHangHoa_ID);
            }
            return View(container);
        }

        // GET: ThongBaoXuatHangs/DeleteContainer/10
        public ActionResult DeleteContainer(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            Container container = db.Containers.Include(c => c.ChiTietHangHoa).FirstOrDefault(c => c.ID == id);
            if (container == null)
            {
                return HttpNotFound();
            }
            return View(container);
        }

        // POST: ThongBaoXuatHangs/DeleteContainer/10
        [HttpPost, ActionName("DeleteContainer")]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteContainerConfirmed(int id)
        {
            Container container = db.Containers.Find(id);
            if (container == null)
            {
                return HttpNotFound();
            }
            int thongBaoId = container.ThongBaoXuatHang_ID;
            db.Containers.Remove(container);
            db.SaveChanges();
            return RedirectToAction("ManageContainers", new { id = thongBaoId });
        }

        #endregion
        #region Delete
        public ActionResult Delete(int? id)
        {
            if (id == null)
            {
                return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            }
            ThongBaoXuatHang thongBaoXuatHang = db.ThongBaoXuatHangs.Include(t => t.KhachHang).FirstOrDefault(t => t.ID == id);
            if (thongBaoXuatHang == null)
            {
                return HttpNotFound();
            }
            return View(thongBaoXuatHang);
        }

        [HttpPost, ActionName("Delete")]
        [ValidateAntiForgeryToken]
        public ActionResult DeleteConfirmed(int id)
        {
            ThongBaoXuatHang thongBao = db.ThongBaoXuatHangs.Find(id);
            if (thongBao == null) return HttpNotFound();

            db.Containers.RemoveRange(thongBao.Containers);
            db.ChiTietHangHoas.RemoveRange(thongBao.ChiTietHangHoas);
            db.ThongBaoXuatHangs.Remove(thongBao);
            db.SaveChanges();
            return RedirectToAction("Index");
        }
        #endregion

        #region New Report/Print Actions
        public ActionResult NewViewReport(int? id)
        {
            if (id == null) return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            var viewModel = GetNewReportViewModel(id);
            if (viewModel == null) return HttpNotFound();
            return View("NewReport", viewModel);
        }

        public ActionResult NewPrint(int? id)
        {
            if (id == null) return new HttpStatusCodeResult(HttpStatusCode.BadRequest);
            var viewModel = GetNewReportViewModel(id);
            if (viewModel == null) return HttpNotFound();
            return new ViewAsPdf("NewReport", viewModel)
            {
                FileName = $"TBXH_{viewModel.REFNO}_{DateTime.Now.ToShortDateString()}.pdf",
                PageSize = Rotativa.Options.Size.A4,
                PageOrientation = Rotativa.Options.Orientation.Landscape,
                PageMargins = { Left = 5, Right = 5, Top = 10, Bottom = 10 },
                CustomSwitches = "--print-media-type"
            };
        }
        #endregion

        #region Helper Methods
        private NewReportViewModel GetNewReportViewModel(int? id)
        {
            var thongBao = GetThongBaoForReport(id);
            if (thongBao == null) return null;

            var fullName = thongBao.CreatedByUser?.FullName ?? thongBao.CreatedById;

            return new NewReportViewModel
            {
                ID = thongBao.ID,
                LoaiHang = thongBao.LoaiHang,
                REFNO = thongBao.REFNO,
                PoNo = thongBao.PoNo,
                // === THÊM 2 DÒNG NÀY ĐỂ TRUYỀN DỮ LIỆU ===
                TenKhachHang = thongBao.KhachHang?.Name, // Lấy tên từ KhachHang liên quan
                TenHangHoa = thongBao.HangHoa?.Name,     // Lấy tên từ HangHoa liên quan
                // ============================================
                NgaydukienString = thongBao.Ngaydukien?.ToString("d/M/yyyy"),
                NgayETDString = thongBao.NgayETD?.ToString("d/M/yyyy"),
                NguoiLapBaoCao = fullName,
                ChiTietList = thongBao.ChiTietHangHoas.Select(ct => new ChiTietReportItem
                {
                    MODEL = ct.MODEL,
                    SIZE = ct.SIZE,
                    NW = ct.NW,
                    GW = ct.GW,
                    Dai = ct.Dai,
                    Rong = ct.Rong,
                    Cao = ct.Cao,
                    COLOR = ct.COLOR,
                    ExtendedContent = ct.ExtendedContent,
                    LotNo = ct.LotNo,
                    SelectedTypeNum = ct.SelectedTypeNum
                }).ToList(),
                ContainerGroups = thongBao.Containers
                    .GroupBy(c => new { c.ContainerSo, c.KichCo })
                    .Select(g => new ContainerGroup
                    {
                        ContainerSo = g.Key.ContainerSo,
                        KichCo = g.Key.KichCo,
                        Items = g.Select(i => new ContainerReportItem
                        {
                            SoLuong = i.SoLuong,
                            ModelName = i.ChiTietHangHoa?.MODEL,
                            Tu = i.Tu,
                            Den = i.Den,
                            GhiChu = i.GhiChu,
                            SelectedTypeNum = i.ChiTietHangHoa?.SelectedTypeNum ?? default
                        }).ToList()
                    }).ToList()
            };
        }

        private ThongBaoXuatHang GetThongBaoForReport(int? id)
        {
            return db.ThongBaoXuatHangs
                     .Include(t => t.KhachHang)
                     .Include(t => t.HangHoa)
                     .Include(t => t.ChiTietHangHoas)
                     .Include(t => t.Containers.Select(c => c.ChiTietHangHoa))
                     .Include(t => t.CreatedByUser)
                     .FirstOrDefault(t => t.ID == id);
        }
        #endregion
        #region Helper Methods
        // Phương thức private để thực hiện logic "cập nhật thông minh"
        private void UpdateChiTietHangHoas(List<ChiTietHangHoaViewModel> chiTietListVM, ThongBaoXuatHang thongBaoInDb)
        {
            var chiTietIdsFromForm = chiTietListVM?.Where(c => c.ID > 0).Select(c => c.ID).ToHashSet() ?? new HashSet<int>();

            var chiTietToDelete = thongBaoInDb.ChiTietHangHoas
                                              .Where(c => !chiTietIdsFromForm.Contains(c.ID))
                                              .ToList();
            foreach (var item in chiTietToDelete)
            {
                // KIỂM TRA AN TOÀN
                if (thongBaoInDb.Containers.Any(c => c.ChiTietHangHoa_ID == item.ID))
                {
                    ModelState.AddModelError("", $"Không thể xóa Model '{item.MODEL}' vì đã được xếp vào container. Vui lòng xóa khỏi container trước.");
                    return; // Dừng lại và báo lỗi
                }
                db.Entry(item).State = EntityState.Deleted; // Đánh dấu để xóa
            }

            if (chiTietListVM != null)
            {
                foreach (var chiTietVM in chiTietListVM)
                {

                    if (chiTietVM.ID > 0) // Cập nhật dòng đã có
                    {
                        var chiTietInDb = thongBaoInDb.ChiTietHangHoas.FirstOrDefault(c => c.ID == chiTietVM.ID);
                        if (chiTietInDb != null)
                        {
                            // Ánh xạ các thuộc tính
                            chiTietInDb.MODEL = chiTietVM.MODEL;
                            chiTietInDb.SIZE = chiTietVM.SIZE;
                            chiTietInDb.NW = chiTietVM.NW;
                            chiTietInDb.GW = chiTietVM.GW;
                            chiTietInDb.Dai = chiTietVM.Dai;
                            chiTietInDb.Rong = chiTietVM.Rong;
                            chiTietInDb.Cao = chiTietVM.Cao;
                            chiTietInDb.COLOR = chiTietVM.COLOR;
                            chiTietInDb.LotNo = chiTietVM.LotNo;
                            chiTietInDb.SelectedTypeNum = chiTietVM.SelectedTypeNum;
                            chiTietInDb.ExtendedContent = chiTietVM.ExtendedContent;
                            chiTietInDb.SoLuongThamKhao = chiTietVM.SoLuongThamKhao;
                            chiTietInDb.QUANTITY = chiTietVM.QUANTITY;
                            chiTietInDb.LastModifiedBy = User.Identity.GetUserId();
                            chiTietInDb.LastModifiedDate = DateTime.Now;
                        }
                    }
                    else // Thêm dòng mới
                    {
                        thongBaoInDb.ChiTietHangHoas.Add(new ChiTietHangHoa
                        {
                            MODEL = chiTietVM.MODEL,
                            SIZE = chiTietVM.SIZE,
                            NW = chiTietVM.NW,
                            GW = chiTietVM.GW,
                            Dai = chiTietVM.Dai,
                            Rong = chiTietVM.Rong,
                            Cao = chiTietVM.Cao,
                            COLOR = chiTietVM.COLOR,
                            LotNo = chiTietVM.LotNo,
                            SelectedTypeNum = chiTietVM.SelectedTypeNum,
                            ExtendedContent = chiTietVM.ExtendedContent,
                            SoLuongThamKhao = chiTietVM.SoLuongThamKhao,
                            QUANTITY = chiTietVM.QUANTITY,
                            LastModifiedBy = User.Identity.GetUserId(),
                            LastModifiedDate = DateTime.Now
                        });
                    }
                }
            }
        }
        #endregion

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

