namespace ShippingMark.Migrations
{
    using System;
    using System.Data.Entity.Migrations;
    
    public partial class InitialCreate : DbMigration
    {
        public override void Up()
        {
            CreateTable(
                "dbo.ChiTietHangHoas",
                c => new
                    {
                        ID = c.Int(nullable: false, identity: true),
                        MODEL = c.String(),
                        SIZE = c.String(),
                        SoLuongThamKhao = c.Int(nullable: false),
                        NW = c.String(),
                        GW = c.String(),
                        Dai = c.Decimal(precision: 18, scale: 2),
                        Rong = c.Decimal(precision: 18, scale: 2),
                        Cao = c.Decimal(precision: 18, scale: 2),
                        COLOR = c.String(),
                        SelectedTypeNum = c.Int(nullable: false),
                        ExtendedContent = c.String(),
                        UsingPrint = c.Boolean(),
                        LotNo = c.String(),
                        QUANTITY = c.String(),
                        CreatedBy = c.String(),
                        CreatedDate = c.DateTime(nullable: false, precision: 7, storeType: "datetime2"),
                        LastModifiedBy = c.String(),
                        LastModifiedDate = c.DateTime(precision: 7, storeType: "datetime2"),
                        ThongBaoXuatHang_ID = c.Int(nullable: false),
                    })
                .PrimaryKey(t => t.ID)
                .ForeignKey("dbo.ThongBaoXuatHangs", t => t.ThongBaoXuatHang_ID, cascadeDelete: true)
                .Index(t => t.ThongBaoXuatHang_ID);
            
            CreateTable(
                "dbo.Containers",
                c => new
                    {
                        ID = c.Int(nullable: false, identity: true),
                        ThongBaoXuatHang_ID = c.Int(nullable: false),
                        ChiTietHangHoa_ID = c.Int(),
                        ContainerSo = c.String(),
                        KichCo = c.String(),
                        SoLuong = c.String(),
                        Tu = c.String(),
                        Den = c.String(),
                        GhiChu = c.String(),
                    })
                .PrimaryKey(t => t.ID)
                .ForeignKey("dbo.ChiTietHangHoas", t => t.ChiTietHangHoa_ID)
                .ForeignKey("dbo.ThongBaoXuatHangs", t => t.ThongBaoXuatHang_ID, cascadeDelete: true)
                .Index(t => t.ThongBaoXuatHang_ID)
                .Index(t => t.ChiTietHangHoa_ID);
            
            CreateTable(
                "dbo.ThongBaoXuatHangs",
                c => new
                    {
                        ID = c.Int(nullable: false, identity: true),
                        LoaiHang = c.String(),
                        SoLuong = c.Int(nullable: false),
                        REFNO = c.String(),
                        PoNo = c.String(),
                        Ngaydukien = c.DateTime(nullable: false),
                        NgayETD = c.DateTime(nullable: false),
                        GhiChu = c.String(),
                        KhachHang_ID = c.Int(),
                        HangHoa_ID = c.Int(),
                        CreatedById = c.String(maxLength: 128),
                        CreatedDate = c.DateTime(nullable: false),
                        LastModifiedById = c.String(maxLength: 128),
                        LastModifiedDate = c.DateTime(),
                    })
                .PrimaryKey(t => t.ID)
                .ForeignKey("dbo.AspNetUsers", t => t.CreatedById)
                .ForeignKey("dbo.HangHoas", t => t.HangHoa_ID)
                .ForeignKey("dbo.KhachHangs", t => t.KhachHang_ID)
                .ForeignKey("dbo.AspNetUsers", t => t.LastModifiedById)
                .Index(t => t.KhachHang_ID)
                .Index(t => t.HangHoa_ID)
                .Index(t => t.CreatedById)
                .Index(t => t.LastModifiedById);
            
            CreateTable(
                "dbo.AspNetUsers",
                c => new
                    {
                        Id = c.String(nullable: false, maxLength: 128),
                        FullName = c.String(nullable: false, maxLength: 100),
                        Email = c.String(maxLength: 256),
                        EmailConfirmed = c.Boolean(nullable: false),
                        PasswordHash = c.String(),
                        SecurityStamp = c.String(),
                        PhoneNumber = c.String(),
                        PhoneNumberConfirmed = c.Boolean(nullable: false),
                        TwoFactorEnabled = c.Boolean(nullable: false),
                        LockoutEndDateUtc = c.DateTime(),
                        LockoutEnabled = c.Boolean(nullable: false),
                        AccessFailedCount = c.Int(nullable: false),
                        UserName = c.String(nullable: false, maxLength: 256),
                    })
                .PrimaryKey(t => t.Id)
                .Index(t => t.UserName, unique: true, name: "UserNameIndex");
            
            CreateTable(
                "dbo.AspNetUserClaims",
                c => new
                    {
                        Id = c.Int(nullable: false, identity: true),
                        UserId = c.String(nullable: false, maxLength: 128),
                        ClaimType = c.String(),
                        ClaimValue = c.String(),
                    })
                .PrimaryKey(t => t.Id)
                .ForeignKey("dbo.AspNetUsers", t => t.UserId, cascadeDelete: true)
                .Index(t => t.UserId);
            
            CreateTable(
                "dbo.AspNetUserLogins",
                c => new
                    {
                        LoginProvider = c.String(nullable: false, maxLength: 128),
                        ProviderKey = c.String(nullable: false, maxLength: 128),
                        UserId = c.String(nullable: false, maxLength: 128),
                    })
                .PrimaryKey(t => new { t.LoginProvider, t.ProviderKey, t.UserId })
                .ForeignKey("dbo.AspNetUsers", t => t.UserId, cascadeDelete: true)
                .Index(t => t.UserId);
            
            CreateTable(
                "dbo.AspNetUserRoles",
                c => new
                    {
                        UserId = c.String(nullable: false, maxLength: 128),
                        RoleId = c.String(nullable: false, maxLength: 128),
                    })
                .PrimaryKey(t => new { t.UserId, t.RoleId })
                .ForeignKey("dbo.AspNetUsers", t => t.UserId, cascadeDelete: true)
                .ForeignKey("dbo.AspNetRoles", t => t.RoleId, cascadeDelete: true)
                .Index(t => t.UserId)
                .Index(t => t.RoleId);
            
            CreateTable(
                "dbo.HangHoas",
                c => new
                    {
                        ID = c.Int(nullable: false, identity: true),
                        Code = c.String(),
                        Name = c.String(),
                    })
                .PrimaryKey(t => t.ID);
            
            CreateTable(
                "dbo.KhachHangs",
                c => new
                    {
                        ID = c.Int(nullable: false, identity: true),
                        Code = c.String(),
                        Name = c.String(),
                    })
                .PrimaryKey(t => t.ID);
            
            CreateTable(
                "dbo.ChiTiets",
                c => new
                    {
                        ID = c.Int(nullable: false, identity: true),
                        REFNO = c.String(),
                        PoNo = c.String(),
                        MODEL = c.String(),
                        SIZE = c.String(),
                        NW = c.String(),
                        GW = c.String(),
                        Dai = c.Decimal(precision: 18, scale: 2),
                        Rong = c.Decimal(precision: 18, scale: 2),
                        Cao = c.Decimal(precision: 18, scale: 2),
                        COLOR = c.String(),
                        Type = c.String(),
                        SelectedTypeNum = c.Int(nullable: false),
                        TypeSuffix = c.String(),
                        usingPrint = c.Boolean(),
                        StartSerial = c.String(),
                        NumSerial = c.String(),
                        LotNo = c.String(),
                        Customer = c.String(),
                        QUANTITY = c.String(),
                        COMMODITY = c.String(),
                        CustomerCode = c.String(),
                        CreatedBy = c.String(),
                        CreatedDate = c.DateTime(nullable: false, precision: 7, storeType: "datetime2"),
                        LastModifiedBy = c.String(),
                        LastModifiedDate = c.DateTime(precision: 7, storeType: "datetime2"),
                    })
                .PrimaryKey(t => t.ID);
            
            CreateTable(
                "dbo.AspNetRoles",
                c => new
                    {
                        Id = c.String(nullable: false, maxLength: 128),
                        Name = c.String(nullable: false, maxLength: 256),
                    })
                .PrimaryKey(t => t.Id)
                .Index(t => t.Name, unique: true, name: "RoleNameIndex");
            
        }
        
        public override void Down()
        {
            DropForeignKey("dbo.AspNetUserRoles", "RoleId", "dbo.AspNetRoles");
            DropForeignKey("dbo.ChiTietHangHoas", "ThongBaoXuatHang_ID", "dbo.ThongBaoXuatHangs");
            DropForeignKey("dbo.Containers", "ThongBaoXuatHang_ID", "dbo.ThongBaoXuatHangs");
            DropForeignKey("dbo.ThongBaoXuatHangs", "LastModifiedById", "dbo.AspNetUsers");
            DropForeignKey("dbo.ThongBaoXuatHangs", "KhachHang_ID", "dbo.KhachHangs");
            DropForeignKey("dbo.ThongBaoXuatHangs", "HangHoa_ID", "dbo.HangHoas");
            DropForeignKey("dbo.ThongBaoXuatHangs", "CreatedById", "dbo.AspNetUsers");
            DropForeignKey("dbo.AspNetUserRoles", "UserId", "dbo.AspNetUsers");
            DropForeignKey("dbo.AspNetUserLogins", "UserId", "dbo.AspNetUsers");
            DropForeignKey("dbo.AspNetUserClaims", "UserId", "dbo.AspNetUsers");
            DropForeignKey("dbo.Containers", "ChiTietHangHoa_ID", "dbo.ChiTietHangHoas");
            DropIndex("dbo.AspNetRoles", "RoleNameIndex");
            DropIndex("dbo.AspNetUserRoles", new[] { "RoleId" });
            DropIndex("dbo.AspNetUserRoles", new[] { "UserId" });
            DropIndex("dbo.AspNetUserLogins", new[] { "UserId" });
            DropIndex("dbo.AspNetUserClaims", new[] { "UserId" });
            DropIndex("dbo.AspNetUsers", "UserNameIndex");
            DropIndex("dbo.ThongBaoXuatHangs", new[] { "LastModifiedById" });
            DropIndex("dbo.ThongBaoXuatHangs", new[] { "CreatedById" });
            DropIndex("dbo.ThongBaoXuatHangs", new[] { "HangHoa_ID" });
            DropIndex("dbo.ThongBaoXuatHangs", new[] { "KhachHang_ID" });
            DropIndex("dbo.Containers", new[] { "ChiTietHangHoa_ID" });
            DropIndex("dbo.Containers", new[] { "ThongBaoXuatHang_ID" });
            DropIndex("dbo.ChiTietHangHoas", new[] { "ThongBaoXuatHang_ID" });
            DropTable("dbo.AspNetRoles");
            DropTable("dbo.ChiTiets");
            DropTable("dbo.KhachHangs");
            DropTable("dbo.HangHoas");
            DropTable("dbo.AspNetUserRoles");
            DropTable("dbo.AspNetUserLogins");
            DropTable("dbo.AspNetUserClaims");
            DropTable("dbo.AspNetUsers");
            DropTable("dbo.ThongBaoXuatHangs");
            DropTable("dbo.Containers");
            DropTable("dbo.ChiTietHangHoas");
        }
    }
}
