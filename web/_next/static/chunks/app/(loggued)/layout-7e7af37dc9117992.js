(self.webpackChunk_N_E=self.webpackChunk_N_E||[]).push([[481],{9841:function(e,t,o){Promise.resolve().then(o.bind(o,5467))},335:function(e,t,o){"use strict";o.d(t,{Z:function(){return j}});var a=o(3950),r=o(2988),l=o(2265),n=o(4839),i=o(6259),s=o(317),c=o(8024),u=o(9281),d=o(5388),h=o(2272),p=o(4535),v=o(4541);function f(e){return(0,v.ZP)("MuiIconButton",e)}let g=(0,p.Z)("MuiIconButton",["root","disabled","colorInherit","colorPrimary","colorSecondary","colorError","colorInfo","colorSuccess","colorWarning","edgeStart","edgeEnd","sizeSmall","sizeMedium","sizeLarge"]);var m=o(7437);let x=["edge","children","className","color","disabled","disableFocusRipple","size"],b=e=>{let{classes:t,disabled:o,color:a,edge:r,size:l}=e,n={root:["root",o&&"disabled","default"!==a&&"color".concat((0,h.Z)(a)),r&&"edge".concat((0,h.Z)(r)),"size".concat((0,h.Z)(l))]};return(0,i.Z)(n,f,t)},Z=(0,c.ZP)(d.Z,{name:"MuiIconButton",slot:"Root",overridesResolver:(e,t)=>{let{ownerState:o}=e;return[t.root,"default"!==o.color&&t["color".concat((0,h.Z)(o.color))],o.edge&&t["edge".concat((0,h.Z)(o.edge))],t["size".concat((0,h.Z)(o.size))]]}})(e=>{let{theme:t,ownerState:o}=e;return(0,r.Z)({textAlign:"center",flex:"0 0 auto",fontSize:t.typography.pxToRem(24),padding:8,borderRadius:"50%",overflow:"visible",color:(t.vars||t).palette.action.active,transition:t.transitions.create("background-color",{duration:t.transitions.duration.shortest})},!o.disableRipple&&{"&:hover":{backgroundColor:t.vars?"rgba(".concat(t.vars.palette.action.activeChannel," / ").concat(t.vars.palette.action.hoverOpacity,")"):(0,s.Fq)(t.palette.action.active,t.palette.action.hoverOpacity),"@media (hover: none)":{backgroundColor:"transparent"}}},"start"===o.edge&&{marginLeft:"small"===o.size?-3:-12},"end"===o.edge&&{marginRight:"small"===o.size?-3:-12})},e=>{var t;let{theme:o,ownerState:a}=e,l=null==(t=(o.vars||o).palette)?void 0:t[a.color];return(0,r.Z)({},"inherit"===a.color&&{color:"inherit"},"inherit"!==a.color&&"default"!==a.color&&(0,r.Z)({color:null==l?void 0:l.main},!a.disableRipple&&{"&:hover":(0,r.Z)({},l&&{backgroundColor:o.vars?"rgba(".concat(l.mainChannel," / ").concat(o.vars.palette.action.hoverOpacity,")"):(0,s.Fq)(l.main,o.palette.action.hoverOpacity)},{"@media (hover: none)":{backgroundColor:"transparent"}})}),"small"===a.size&&{padding:5,fontSize:o.typography.pxToRem(18)},"large"===a.size&&{padding:12,fontSize:o.typography.pxToRem(28)},{["&.".concat(g.disabled)]:{backgroundColor:"transparent",color:(o.vars||o).palette.action.disabled}})});var j=l.forwardRef(function(e,t){let o=(0,u.Z)({props:e,name:"MuiIconButton"}),{edge:l=!1,children:i,className:s,color:c="default",disabled:d=!1,disableFocusRipple:h=!1,size:p="medium"}=o,v=(0,a.Z)(o,x),f=(0,r.Z)({},o,{edge:l,color:c,disabled:d,disableFocusRipple:h,size:p}),g=b(f);return(0,m.jsx)(Z,(0,r.Z)({className:(0,n.Z)(g.root,s),centerRipple:!0,focusRipple:!h,disabled:d,ref:t},v,{ownerState:f,children:i}))})},5467:function(e,t,o){"use strict";o.r(t),o.d(t,{default:function(){return h}});var a=o(7437),r=o(7138);o(2265);var l=o(6845),n=o(335),i=o(6648),s=o(606),c=()=>{let{logout:e,user:t}=(0,s.a)();return console.log(t),(0,a.jsxs)("div",{className:" h-16 w-40 bg-white/5 efecto-vidrio flex items-center gap-2 p-2 z-50\n    ",children:[(0,a.jsx)("div",{className:"h-full aspect-square overflow-hidden",children:(0,a.jsx)(i.default,{src:(null==t?void 0:t.image)||"/assets/user.png",height:60,width:60,className:"h-full w-full rounded-full shadow-md overflow-hidden object-cover"})}),(0,a.jsxs)("div",{className:" text-2xs font-thin text-white",children:[(0,a.jsx)("p",{className:" font-light",children:null==t?void 0:t.name}),(0,a.jsx)("p",{children:null==t?void 0:t.username})]}),(0,a.jsx)("div",{className:"absolute bottom-0 right-0 ",children:(0,a.jsx)(n.Z,{size:"small",onClick:e,children:(0,a.jsx)(l.Z,{fontSize:"small",className:" text-white/60"})})})]})},u=o(6463);let d=[{label:"Productos",href:"/productos",public:!0},{label:"Categorias",href:"/categorias",public:!1},{label:"Usuarios",href:"/usuarios",public:!1}];var h=e=>{let{children:t}=e,{isAuthenticated:o}=(0,s.a)();return(0,a.jsxs)("div",{className:" h-full flex",children:[(0,a.jsx)("div",{className:" flex flex-col h-full text-5xl font-thin gap-6 p-6 text-white w-[15%] min-w-[300px]",children:null==d?void 0:d.map((e,t)=>{let l=(0,u.usePathname)();if(e.public||o)return(0,a.jsx)(r.default,{href:e.href,className:"\n                        hover:font-extralight\n                        ".concat(l===e.href&&"font-light","\n                        "),children:e.label})})}),o?(0,a.jsx)("div",{className:"absolute right-3 top-3",children:(0,a.jsx)(c,{})}):(0,a.jsx)(r.default,{href:"/login",className:"absolute top-1 right-4 text-xxs text-white",children:"Ingresar"}),(0,a.jsx)("main",{className:"  w-full p-6",children:t})]})}},606:function(e,t,o){"use strict";o.d(t,{H:function(){return u},a:function(){return d}});var a=o(7437),r=o(2265),l=o(8254),n=o(2649),i=o(6463),s=o(5041);let c=(0,r.createContext)(null),u=e=>{let{children:t}=e,[o,u]=(0,r.useState)(null),d=(0,i.useRouter)(),h=()=>{let e=n.Z.get("token");e&&l.Z.get("/api/getuser",{headers:{Authorization:"Bearer ".concat(e)}}).then(e=>u(e.data.data)).catch(()=>n.Z.remove("token"))};(0,r.useEffect)(()=>{h()},[]);let p=async(e,t,o)=>{var a,r,i;try{let r=await l.Z.post("/api/login",{username:e,password:t});r.data.token&&(n.Z.set("token",r.data.token,{expires:1}),u(r.data.user),(0,s.yv)(null==r?void 0:null===(a=r.data)||void 0===a?void 0:a.message,{variant:"success"}),o&&setTimeout(()=>{h(),d.push(o)},500))}catch(e){console.log(e),(0,s.yv)(null==e?void 0:null===(i=e.response)||void 0===i?void 0:null===(r=i.data)||void 0===r?void 0:r.message,{variant:"error"})}};return(0,a.jsx)(c.Provider,{value:{isAuthenticated:!!o,user:o,login:p,logout:()=>{n.Z.remove("token"),u(null),d.refresh()}},children:t})},d=()=>(0,r.useContext)(c)},8254:function(e,t,o){"use strict";var a=o(8472),r=o(2649);let l=a.Z.create({baseURL:"http://localhost:8000"});l.interceptors.request.use(e=>{let t=r.Z.get("token");return t&&(e.headers.Authorization="Bearer ".concat(t)),e},e=>Promise.reject(e)),t.Z=l}},function(e){e.O(0,[355,648,756,971,23,744],function(){return e(e.s=9841)}),_N_E=e.O()}]);