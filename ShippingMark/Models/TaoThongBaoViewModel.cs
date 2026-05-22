using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Web.Mvc;

namespace ShippingMark.Models
{
    public class TaoThongBaoViewModel
    {
        public int ID { get; set; }
        // --- PHẦN 1: THÔNG TIN CHUNG ---
        [Display(Name = "Khách hàng")]
        [Required(ErrorMessage = "Vui lòng chọn khách hàng.")]
        public int? KhachHangID { get; set; }

        [Display(Name = "Danh mục Hàng hóa")]
        [Required(ErrorMessage = "Vui lòng chọn loại hàng hóa.")]
        public int HangHoaID { get; set; }

        // Thuộc tính mới
        [Display(Name = "Loại hàng (chi tiết)")]
        public string LoaiHang { get; set; }

        // Thuộc tính mới
        [Display(Name = "Tổng số lượng")]
        [Range(1, int.MaxValue, ErrorMessage = "Số lượng phải lớn hơn 0.")]
        public int SoLuong { get; set; }

        [Display(Name = "Đơn hàng (REFNO)")]
        public string DonHang { get; set; }

        [Display(Name = "Số PO")]
        public string SoPO { get; set; }

        [Display(Name = "Ngày xuất hàng dự kiến")]
        [Required(ErrorMessage = "Vui lòng chọn ngày.")]
        [DataType(DataType.Date)]
        public DateTime NgayXuatHang { get; set; }

        [Display(Name = "ETD")]
        [Required(ErrorMessage = "Vui lòng chọn ngày.")]
        [DataType(DataType.Date)]
        public DateTime ETD { get; set; }

        // --- Dùng để đổ dữ liệu vào Dropdown ---
        public SelectList KhachHangList { get; set; }
        public SelectList HangHoaList { get; set; }

        // --- PHẦN 2 & 3: DANH SÁCH CHI TIẾT ---
        public List<ChiTietHangHoaViewModel> ChiTietList { get; set; }
        public List<SapXepContainerViewModel> ContainerList { get; set; }

        public TaoThongBaoViewModel()
        {
            ChiTietList = new List<ChiTietHangHoaViewModel>();
            ContainerList = new List<SapXepContainerViewModel>();
            NgayXuatHang = DateTime.Now;
            ETD = DateTime.Now;
        }
    }
}

