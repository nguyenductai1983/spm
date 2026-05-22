using NPOI.SS.UserModel;
using NPOI.XSSF.UserModel;
using NPOI.HSSF.UserModel;
using System.Data.Entity;
using System.IO;
using System.Web;
using System.Web.Mvc;
using System.Linq;
using System.Collections.Generic;
using System;
using ShippingMark.Models;

public class ChiTietController : Controller
{
  readonly  private ApplicationDbContext db = new ApplicationDbContext();

    // GET: IFT/Import
    public ActionResult Import()
    {
        return View();
    }

    // POST: IFT/Import
    [HttpPost]
    [ValidateAntiForgeryToken]
    public ActionResult Import(HttpPostedFileBase file)
    {
        if (file == null || file.ContentLength <= 0)
        {
            ViewBag.IsSuccess = false;
            ViewBag.Message = "Vui lòng chọn một file để tải lên.";
            return View();
        }

        try
        {
            IWorkbook workbook = null;
            if (file.FileName.EndsWith("xlsx"))
            {
                workbook = new XSSFWorkbook(file.InputStream);
            }
            else if (file.FileName.EndsWith("xls"))
            {
                workbook = new HSSFWorkbook(file.InputStream);
            }
            else
            {
                ViewBag.IsSuccess = false;
                ViewBag.Message = "Định dạng file không hợp lệ. Vui lòng chọn file .xlsx hoặc .xls.";
                return View();
            }

            ISheet sheet = workbook.GetSheetAt(0);
            var listIft = new List<ShippingMark.Models.ChiTiet>();

            var currentUser = User.Identity.Name;

            // Bắt đầu từ hàng thứ 2 (chỉ số 1) để bỏ qua tiêu đề
            for (int row = 1; row <= sheet.LastRowNum; row++)
            {
                IRow currentRow = sheet.GetRow(row);
                if (currentRow == null) continue;

                // Tạo một đối tượng IFT mới
                var ift = new ShippingMark.Models.ChiTiet();

                // Ánh xạ dữ liệu từ Excel vào các trường của Model IFT
                // Lưu ý: Các chỉ số cột (0, 1, 2, ...) phải khớp với thứ tự các cột trong file Excel của bạn.
                ift.REFNO = currentRow.GetCell(0)?.ToString();
                ift.PoNo = currentRow.GetCell(1)?.ToString();
                ift.CustomerCode = currentRow.GetCell(2)?.ToString();
                ift.MODEL = currentRow.GetCell(3)?.ToString();
                ift.SIZE = currentRow.GetCell(4)?.ToString();
                ift.NW = currentRow.GetCell(5)?.ToString();
                ift.GW = currentRow.GetCell(6)?.ToString();
                ift.Dai = Convert.ToDecimal(currentRow.GetCell(7)?.ToString());
                ift.Rong = Convert.ToDecimal(currentRow.GetCell(8)?.ToString());
                ift.Cao = Convert.ToDecimal(currentRow.GetCell(9)?.ToString());
                ift.COLOR = currentRow.GetCell(10)?.ToString();
                ift.StartSerial = currentRow.GetCell(11)?.ToString();
                ift.NumSerial = currentRow.GetCell(12)?.ToString();

                var selectedTypeNumCell = currentRow.GetCell(13); // Lấy ô chứa giá trị TypeNum

                // Logic mới: Đọc giá trị số từ ô Excel.
                // Nếu là 1 thì gán là PACKAGENO, ngược lại (là 0, rỗng, hoặc text) thì mặc định là ROLLNO.
                if (selectedTypeNumCell != null && selectedTypeNumCell.CellType == NPOI.SS.UserModel.CellType.Numeric && selectedTypeNumCell.NumericCellValue == 1)
                {
                    // Nếu giá trị trong ô là số 1, gán là PACKAGENO
                    ift.SelectedTypeNum = TypeNum.PACKAGENO;
                }
                else
                {
                    // Trong tất cả các trường hợp khác, mặc định là ROLLNO
                    ift.SelectedTypeNum = TypeNum.ROLLNO;
                }

                var usingPrintCell = currentRow.GetCell(14);                
                if (usingPrintCell != null)
                {
                    // Kiểm tra nếu là kiểu boolean
                    if (usingPrintCell.CellType == NPOI.SS.UserModel.CellType.Boolean)
                    {
                        ift.usingPrint = usingPrintCell.BooleanCellValue;
                    }
                    // Hoặc nếu là kiểu số và có giá trị là 1
                    else if (usingPrintCell.CellType == NPOI.SS.UserModel.CellType.Numeric && usingPrintCell.NumericCellValue == 1)
                    {
                        ift.usingPrint = true;
                    }
                    // Ngược lại, nếu là số 0 hoặc kiểu dữ liệu khác
                    else
                    {
                        ift.usingPrint = false;
                    }
                }
                else
                {
                    // Nếu ô là null, gán false
                    ift.usingPrint = false;
                }
                ift.LotNo = currentRow.GetCell(15)?.ToString();
                // TYPENUM không có trong model IFT, có thể bỏ qua hoặc xử lý riêng
                ift.Type = currentRow.GetCell(16)?.ToString();               
                ift.TypeSuffix = currentRow.GetCell(17)?.ToString();
                ift.Customer = currentRow.GetCell(18)?.ToString();                
                ift.QUANTITY = currentRow.GetCell(19)?.ToString();
                ift.COMMODITY = currentRow.GetCell(20)?.ToString();

                // Ghi nhận thông tin user và thời gian
                ift.CreatedBy = currentUser;
                ift.CreatedDate = DateTime.Now;

                listIft.Add(ift);
            }

            // Lưu tất cả các đối tượng IFT đã tạo vào database
            db.ChiTiets.AddRange(listIft);
            db.SaveChanges();

            ViewBag.IsSuccess = true;
            ViewBag.Message = $"Thành công! Đã import {listIft.Count} dòng dữ liệu.";
        }
        catch (Exception ex)
        {
            ViewBag.IsSuccess = false;
            ViewBag.Message = $"Đã xảy ra lỗi: {ex.Message}. Vui lòng kiểm tra lại định dạng file Excel.";
        }

        return View();
    }
    public ActionResult ExportTemplate()
    {
        // Tạo một workbook mới
        IWorkbook workbook = new XSSFWorkbook();
        ISheet sheet = workbook.CreateSheet("SM Template");

        // Tạo một hàng đầu tiên cho tiêu đề
        IRow headerRow = sheet.CreateRow(0);

        // Định nghĩa các tiêu đề cột tương ứng với các thuộc tính của model IFT
        string[] headers = new string[] {
        "REFNO", "PoNo", "Mã PO 3 kí tự", "MODEL", "SIZE", "NW","GW", "Dài (m)", "Rộng (m)", "Cao (m)", "COLOR", "Số bắt đầu", "Số lượng in", "0 Cuộn 1 Kiện",
        "In 0 - Không in 1", "LotNo", "ROLL/PACKAGE No.", "Nội dung sau số nhảy", "Customer", 
        "QUANTITY", "COMMODITY"
    };

        // Ghi các tiêu đề vào hàng đầu tiên
        for (int i = 0; i < headers.Length; i++)
        {
            headerRow.CreateCell(i).SetCellValue(headers[i]);
        }

        // Ghi workbook vào một MemoryStream
        using (var exportData = new MemoryStream())
        {
            workbook.Write(exportData);
            string saveAsFileName = "SM_Template_" + DateTime.Now.ToString("yyyyMMddHHmmss") + ".xlsx";

            // Trả về file cho người dùng để tải xuống
            return File(exportData.ToArray(), "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", saveAsFileName);
        }
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