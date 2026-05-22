using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Web.Mvc;

namespace ShippingMark.Models
{
    // Lớp cha để chứa toàn bộ thông tin cho View "ManageContainers"
    public class ManageContainersViewModel
    {
        // Phần 1: Thông tin tóm tắt của phiếu (đã được xử lý sẵn)
        public ThongBaoInfoViewModel ThongBaoInfo { get; set; }

        // Phần 2: Danh sách các container đã có (đã được xử lý sẵn)
        public List<ExistingContainerViewModel> ExistingContainers { get; set; }

        // Phần 3: Form để thêm một container mới
        public AddContainerFormViewModel AddContainerForm { get; set; }

        // Constructor để đảm bảo các đối tượng con không bị null
        public ManageContainersViewModel()
        {
            ThongBaoInfo = new ThongBaoInfoViewModel();
            ExistingContainers = new List<ExistingContainerViewModel>();
            AddContainerForm = new AddContainerFormViewModel();
        }
    }

    // Lớp con chỉ chứa thông tin tóm tắt của phiếu để hiển thị
    public class ThongBaoInfoViewModel
    {
        public int ID { get; set; }
        public string KhachHangName { get; set; }
        public string DanhMucName { get; set; }
        public string SoPO { get; set; }
        public string REFNO { get; set; }
    }

    // Lớp con chỉ chứa thông tin hiển thị của một container đã tồn tại
    public class ExistingContainerViewModel
    {
        // === NÂNG CẤP: Thêm ID để tạo link Sửa/Xóa ===
        public int ContainerID { get; set; }
        public string ContainerSo { get; set; }
        public string KichCo { get; set; }
        public string ModelName { get; set; }
        public string SoLuong { get; set; }
        public string TuDen { get; set; }
        public string GhiChu { get; set; }
    }

    // Lớp con cho form "Thêm mới container"
    public class AddContainerFormViewModel
    {
        public int ThongBaoID { get; set; }

        [Display(Name = "Container số")]
        public string ContainerSo { get; set; }

        [Display(Name = "Kích cỡ")]
        public string KichCo { get; set; }

        [Display(Name = "Model")]
        [Required(ErrorMessage = "Vui lòng chọn một Model.")]
        public int? ChiTietHangHoa_ID { get; set; }

        [Display(Name = "Số lượng")]
        public string SoLuong { get; set; }

        [Display(Name = "Từ")]
        public string Tu { get; set; }

        [Display(Name = "Đến")]
        public string Den { get; set; }

        [Display(Name = "Ghi chú")]
        public string GhiChu { get; set; }

        public SelectList AvailableModelsList { get; set; }
    }
}

