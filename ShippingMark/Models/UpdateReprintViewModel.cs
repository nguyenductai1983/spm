// File: Models/UpdateReprintViewModel.cs
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;

namespace ShippingMark.Models
{
    public class UpdateReprintViewModel
    {
        // ID của ChiTietHangHoa đang sửa
        public int ChiTietHangHoaId { get; set; }

        // Tên MODEL để hiển thị trên trang
        public string ModelName { get; set; }

        // Danh sách các container cần cập nhật
        public List<ContainerUpdateItem> Containers { get; set; }

        public UpdateReprintViewModel()
        {
            Containers = new List<ContainerUpdateItem>();
        }
    }

    public class ContainerUpdateItem
    {
        // ID của container để biết cập nhật dòng nào
        public int ContainerId { get; set; }

        // Thông tin hiển thị (không cho sửa)
        [Display(Name = "Container số")]
        public string ContainerSo { get; set; }

        // Các trường cho phép sửa
        [Display(Name = "Số bắt đầu (Từ)")]
        public string Tu { get; set; }

        [Display(Name = "Số lượng")]
        public string SoLuong { get; set; }
    }
}