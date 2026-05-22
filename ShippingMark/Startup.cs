using Microsoft.Owin;
using Owin;

[assembly: OwinStartupAttribute(typeof(ShippingMark.Startup))]
namespace ShippingMark
{
    public partial class Startup
    {
        public void Configuration(IAppBuilder app)
        {
            ConfigureAuth(app);
        }
    }
}
