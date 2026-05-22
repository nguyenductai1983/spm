using System;
using System.ComponentModel.DataAnnotations;

namespace ShippingMark.Models
{
    /// <summary>
    /// ViewModel này chỉ chứa các thông tin cần thiết để hiển thị
    /// trên trang danh sách (Index), giúp tối ưu và tránh các lỗi liên quan đến proxy.
    /// </summary>
    public class ThongBaoIndexViewModel
    {
        public int ID { get; set; }

        [Display(Name = "Tên khách hàng")]
        public string KhachHangName { get; set; }

        [Display(Name = "PoNo Số PO")]
        public string PoNo { get; set; }

        [Display(Name = "REFNO Đơn hàng")]
        public string REFNO { get; set; }

        [Display(Name = "Ngày dự kiến")]
        [DisplayFormat(DataFormatString = "{0:dd/MM/yyyy}")]
        public DateTime? Ngaydukien { get; set; }
    }
}
