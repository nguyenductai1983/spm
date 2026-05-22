using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;

namespace ShippingMark.Models
{
    // Lớp cha chứa toàn bộ dữ liệu cho trang báo cáo
    public class NewReportViewModel
    {
        // Thông tin chung
        public int ID { get; set; }
        public string LoaiHang { get; set; }
        public string REFNO { get; set; }
        public string PoNo { get; set; }
        public string NgaydukienString { get; set; }
        // === THÊM 2 DÒNG NÀY ===
        public string TenKhachHang { get; set; }
        public string TenHangHoa { get; set; }
        // ========================
        public string NgayETDString { get; set; }        
        public string NguoiLapBaoCao { get; set; }
        // Bảng 1: Chi tiết hàng hóa
        public List<ChiTietReportItem> ChiTietList { get; set; }

        // Bảng 2: Các nhóm container
        public List<ContainerGroup> ContainerGroups { get; set; }

        public NewReportViewModel()
        {
            ChiTietList = new List<ChiTietReportItem>();
            ContainerGroups = new List<ContainerGroup>();
        }
    }

    // Lớp đại diện cho một dòng trong bảng chi tiết hàng hóa
    public class ChiTietReportItem
    {
        public string MODEL { get; set; }
        public string SIZE { get; set; }
        public string NumSerial { get; set; }
        public string NW { get; set; }
        public string GW { get; set; }
        public decimal? Dai { get; set; }
        public decimal? Rong { get; set; }
        public decimal? Cao { get; set; }
        public string LotNo { get; set; }
        public string COLOR { get; set; }
        public string ExtendedContent { get; set; }
        public TypeNum SelectedTypeNum { get; set; }
    }

    // Lớp đại diện cho một nhóm container (có cùng số container)
    public class ContainerGroup
    {
        public string ContainerSo { get; set; }
        public string KichCo { get; set; }
        public List<ContainerReportItem> Items { get; set; }
        public ContainerGroup() { Items = new List<ContainerReportItem>(); }
    }

    // Lớp đại diện cho một dòng sản phẩm trong một container
    public class ContainerReportItem
    {
        public string SoLuong { get; set; }
        public string ModelName { get; set; }
        public string Tu { get; set; }
        public string Den { get; set; }
        public string GhiChu { get; set; }
        public TypeNum SelectedTypeNum { get; set; }
    }
}
