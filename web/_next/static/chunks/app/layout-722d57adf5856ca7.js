(self.webpackChunk_N_E=self.webpackChunk_N_E||[]).push([[185],{5546:function(e,t,l){Promise.resolve().then(l.t.bind(l,3197,23)),Promise.resolve().then(l.t.bind(l,210,23)),Promise.resolve().then(l.t.bind(l,3054,23)),Promise.resolve().then(l.bind(l,5467)),Promise.resolve().then(l.bind(l,1722))},1705:function(e,t,l){"use strict";l.d(t,{Z:function(){return _}});var n=l(2988),r=l(3950),i=l(2265);let a=i.createContext(null);function o(){return i.useContext(a)}var s="function"==typeof Symbol&&Symbol.for?Symbol.for("mui.nested"):"__THEME_NESTED__",u=l(7437),c=function(e){let{children:t,theme:l}=e,r=o(),c=i.useMemo(()=>{let e=null===r?l:"function"==typeof l?l(r):(0,n.Z)({},r,l);return null!=e&&(e[s]=null!==r),e},[l,r]);return(0,u.jsx)(a.Provider,{value:c,children:t})},h=l(6132),f=l(4828),d=l(5158);let m={};function v(e,t,l){let r=arguments.length>3&&void 0!==arguments[3]&&arguments[3];return i.useMemo(()=>{let i=e&&t[e]||t;if("function"==typeof l){let a=l(i),o=e?(0,n.Z)({},t,{[e]:a}):a;return r?()=>o:o}return e?(0,n.Z)({},t,{[e]:l}):(0,n.Z)({},t,l)},[e,t,l,r])}var x=function(e){let{children:t,theme:l,themeId:n}=e,r=(0,f.Z)(m),i=o()||m,a=v(n,r,l),s=v(n,i,l,!0),x="rtl"===a.direction;return(0,u.jsx)(c,{theme:s,children:(0,u.jsx)(h.T.Provider,{value:a,children:(0,u.jsx)(d.Z,{value:x,children:t})})})},g=l(2737);let p=["theme"];function _(e){let{theme:t}=e,l=(0,r.Z)(e,p),i=t[g.Z];return(0,u.jsx)(x,(0,n.Z)({},l,{themeId:i?g.Z:void 0,theme:i||t}))}},5467:function(e,t,l){"use strict";l.r(t),l.d(t,{default:function(){return f}});var n=l(7437),r=l(7138);l(2265);var i=l(6845),a=l(335),o=l(6648),s=l(606),u=()=>{let{logout:e,user:t}=(0,s.a)();return console.log(t),(0,n.jsxs)("div",{className:" h-16 w-40 bg-white/5 efecto-vidrio flex items-center gap-2 p-2 z-50\n    ",children:[(0,n.jsx)("div",{className:"h-full aspect-square overflow-hidden",children:(0,n.jsx)(o.default,{src:(null==t?void 0:t.image)||"/assets/user.png",height:60,width:60,className:"h-full w-full rounded-full shadow-md overflow-hidden object-cover"})}),(0,n.jsxs)("div",{className:" text-2xs font-thin text-white",children:[(0,n.jsx)("p",{className:" font-light",children:null==t?void 0:t.name}),(0,n.jsx)("p",{children:null==t?void 0:t.username})]}),(0,n.jsx)("div",{className:"absolute bottom-0 right-0 ",children:(0,n.jsx)(a.Z,{size:"small",onClick:e,children:(0,n.jsx)(i.Z,{fontSize:"small",className:" text-white/60"})})})]})},c=l(6463);let h=[{label:"Productos",href:"/productos",public:!0},{label:"Categorias",href:"/categorias",public:!1},{label:"Usuarios",href:"/usuarios",public:!1}];var f=e=>{let{children:t}=e,{isAuthenticated:l}=(0,s.a)();return(0,n.jsxs)("div",{className:" h-full flex",children:[(0,n.jsx)("div",{className:" flex flex-col h-full text-5xl font-thin gap-6 p-6 text-white w-[15%] min-w-[300px]",children:null==h?void 0:h.map((e,t)=>{let i=(0,c.usePathname)();if(e.public||l)return(0,n.jsx)(r.default,{href:e.href,className:"\n                        hover:font-extralight\n                        ".concat(i===e.href&&"font-light","\n                        "),children:e.label})})}),l?(0,n.jsx)("div",{className:"absolute right-3 top-3",children:(0,n.jsx)(u,{})}):(0,n.jsx)(r.default,{href:"/login",className:"absolute top-1 right-4 text-xxs text-white",children:"Ingresar"}),(0,n.jsx)("main",{className:"  w-full p-6",children:t})]})}},606:function(e,t,l){"use strict";l.d(t,{H:function(){return c},a:function(){return h}});var n=l(7437),r=l(2265),i=l(8254),a=l(2649),o=l(6463),s=l(5041);let u=(0,r.createContext)(null),c=e=>{let{children:t}=e,[l,c]=(0,r.useState)(null),h=(0,o.useRouter)(),f=()=>{let e=a.Z.get("token");e&&i.Z.get("/api/getuser",{headers:{Authorization:"Bearer ".concat(e)}}).then(e=>c(e.data.data)).catch(()=>a.Z.remove("token"))};(0,r.useEffect)(()=>{f()},[]);let d=async(e,t,l)=>{var n,r,o;try{let r=await i.Z.post("/api/login",{username:e,password:t});r.data.token&&(a.Z.set("token",r.data.token,{expires:1}),c(r.data.user),(0,s.yv)(null==r?void 0:null===(n=r.data)||void 0===n?void 0:n.message,{variant:"success"}),l&&setTimeout(()=>{f(),h.push(l)},500))}catch(e){console.log(e),(0,s.yv)(null==e?void 0:null===(o=e.response)||void 0===o?void 0:null===(r=o.data)||void 0===r?void 0:r.message,{variant:"error"})}};return(0,n.jsx)(u.Provider,{value:{isAuthenticated:!!l,user:l,login:d,logout:()=>{a.Z.remove("token"),c(null),h.refresh()}},children:t})},h=()=>(0,r.useContext)(u)},1722:function(e,t,l){"use strict";l.d(t,{W:function(){return u}});var n=l(7437),r=l(4444),i=l(1705);l(2265);var a=l(606),o=l(1777),s=l(5041);let u=(0,r.Z)({palette:{mode:"light"},typography:{fontFamily:"var(--font-helvetica)",fontWeightLight:100,fontWeightRegular:300,fontWeightBold:400,fontWeightMedium:200,fontSize:11}});t.default=e=>{let{children:t}=e,l=(0,r.Z)({palette:{mode:"dark"},typography:{fontFamily:"var(--font-helvetica)",fontWeightLight:100,fontWeightRegular:300,fontWeightBold:400,fontWeightMedium:200,fontSize:11}});return(0,n.jsx)(n.Fragment,{children:(0,n.jsx)(a.H,{children:(0,n.jsx)(i.Z,{theme:u,children:(0,n.jsx)(o.WT,{children:(0,n.jsx)(i.Z,{theme:l,children:(0,n.jsx)(s.wT,{anchorOrigin:{vertical:"top",horizontal:"left"},className:" font-thin",children:t})})})})})})}},8254:function(e,t,l){"use strict";var n=l(8472),r=l(2649);let i=n.Z.create({baseURL:"http://localhost:8000"});i.interceptors.request.use(e=>{let t=r.Z.get("token");return t&&(e.headers.Authorization="Bearer ".concat(t)),e},e=>Promise.reject(e)),t.Z=i},3054:function(){},3197:function(e){e.exports={style:{fontFamily:"'__Montserrat_2f6838', '__Montserrat_Fallback_2f6838'",fontStyle:"normal"},className:"__className_2f6838",variable:"__variable_2f6838"}},210:function(e){e.exports={style:{fontFamily:"'__helvetica_6f9731', '__helvetica_Fallback_6f9731'"},className:"__className_6f9731",variable:"__variable_6f9731"}}},function(e){e.O(0,[738,355,576,434,648,756,971,23,744],function(){return e(e.s=5546)}),_N_E=e.O()}]);