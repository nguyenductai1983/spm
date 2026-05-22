using System.ComponentModel.DataAnnotations;

namespace ShippingMark.Models // Hoặc namespace ViewModel của bạn
{
    public class SapXepContainerViewModel
    {
        [Display(Name = "Container số")]
        public string ContainerSo { get; set; }

        [Display(Name = "Kích cỡ container")]
        public string KichCoContainer { get; set; }

        [Display(Name = "Số cuộn")]
        public int SoCuon { get; set; }

        [Display(Name = "Model")]
        public string Model { get; set; }

        [Display(Name = "STT Từ")]
        public int SerialTu { get; set; }

        [Display(Name = "STT Đến")]
        public int SerialDen { get; set; }

        [Display(Name = "Ghi chú")]
        public string GhiChu { get; set; }
    }
}