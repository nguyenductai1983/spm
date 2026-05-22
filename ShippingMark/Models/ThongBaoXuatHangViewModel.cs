using System.Collections.Generic;
using System.Web.Mvc;

namespace ShippingMark.Models
{
    public class ThongBaoXuatHangViewModel
    {
        // Phần Master: Thông tin chung của phiếu
        public ThongBaoXuatHang ThongBao { get; set; }

        // Phần Detail: Danh sách các container trong phiếu
        public List<Container> Containers { get; set; }

        // Dùng để đổ dữ liệu vào dropdownlist chọn Model (IFT)
        public SelectList IFTList { get; set; }
    }
}