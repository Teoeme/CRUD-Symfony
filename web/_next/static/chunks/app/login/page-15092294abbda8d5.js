(self.webpackChunk_N_E=self.webpackChunk_N_E||[]).push([[626],{3584:function(e,t,a){Promise.resolve().then(a.bind(a,4604))},606:function(e,t,a){"use strict";a.d(t,{H:function(){return c},a:function(){return d}});var n=a(7437),s=a(2265),r=a(8254),o=a(2649),l=a(6463),u=a(5041);let i=(0,s.createContext)(null),c=e=>{let{children:t}=e,[a,c]=(0,s.useState)(null),d=(0,l.useRouter)(),v=()=>{let e=o.Z.get("token");e&&r.Z.get("/api/getuser",{headers:{Authorization:"Bearer ".concat(e)}}).then(e=>c(e.data.data)).catch(()=>o.Z.remove("token"))};(0,s.useEffect)(()=>{v()},[]);let h=async(e,t,a)=>{var n,s,l;try{let s=await r.Z.post("/api/login",{username:e,password:t});s.data.token&&(o.Z.set("token",s.data.token,{expires:1}),c(s.data.user),(0,u.yv)(null==s?void 0:null===(n=s.data)||void 0===n?void 0:n.message,{variant:"success"}),a&&setTimeout(()=>{v(),d.push(a)},500))}catch(e){console.log(e),(0,u.yv)(null==e?void 0:null===(l=e.response)||void 0===l?void 0:null===(s=l.data)||void 0===s?void 0:s.message,{variant:"error"})}};return(0,n.jsx)(i.Provider,{value:{isAuthenticated:!!a,user:a,login:h,logout:()=>{o.Z.remove("token"),c(null),d.refresh()}},children:t})},d=()=>(0,s.useContext)(i)},4604:function(e,t,a){"use strict";a.r(t);var n=a(7437),s=a(606),r=a(3983),o=a(6548),l=a(2265);t.default=()=>{let[e,t]=(0,l.useState)({username:"",password:""}),a=e=>{let{value:a,name:n}=e.target;t(e=>({...e,[n]:a}))},{login:u}=(0,s.a)(),i=async()=>{await u(e.username,e.password,"/productos")};return(0,n.jsx)("div",{className:"h-full items-center flex w-full justify-center",children:(0,n.jsxs)("div",{className:" efecto-vidrio h-[200] w-[300px] flex flex-col gap-3 p-10",children:[(0,n.jsx)(r.Z,{size:"small",onChange:a,name:"username",value:e.username,label:"usuario"}),(0,n.jsx)(r.Z,{label:"contrase\xf1a",size:"small",type:"password",onChange:a,name:"password",value:e.password,onKeyUp:e=>{"Enter"===e.key&&i()}}),(0,n.jsx)(o.Z,{variant:"outlined",onClick:i,children:"Iniciar Sesi\xf3n"})]})})}},8254:function(e,t,a){"use strict";var n=a(8472),s=a(2649);let r=n.Z.create({baseURL:"http://localhost:8000"});r.interceptors.request.use(e=>{let t=s.Z.get("token");return t&&(e.headers.Authorization="Bearer ".concat(t)),e},e=>Promise.reject(e)),t.Z=r}},function(e){e.O(0,[355,576,971,23,744],function(){return e(e.s=3584)}),_N_E=e.O()}]);