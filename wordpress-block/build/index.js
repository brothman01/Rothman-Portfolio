!function(){"use strict";var e,t={289:function(e,t,r){var n=window.React,o=r.n(n),i=window.wp.blocks,s=window.ReactDOM,c=r.n(s),a=window.wp.i18n,l=window.wp.blockEditor,u=JSON.parse('{"u2":"create-block/my-block"}'),p=r.p+"images/spinner.9a117e77.gif";class f extends o().Component{constructor(e){super(e),this.state={posts:[],showSpinner:!0}}componentDidMount(){this.timer=setInterval((()=>{this.setState({showSpinner:!1})}),3e3),fetch(vars.rest_url,{method:"GET"}).then((e=>e.json())).then((e=>this.setState({posts:e})))}createRows=()=>{const{posts:e}=this.state;return e&&e.length?e.map(((e,t)=>this.createRow(e))):(0,n.createElement)("p",null,"There are no items to render.")};createRow(e){let t=e.link,r=e._embedded["wp:featuredmedia"][0].source_url,o=e.title.rendered;return(0,n.createElement)("div",{class:"col-lg-3 col-md-2 col-sm-12 bp-portfolio-item-cell"},(0,n.createElement)("a",{href:t},(0,n.createElement)("img",{class:"portfolio-grid-box-image",src:r}),(0,n.createElement)("p",null,o)))}render(){return!1===this.state.showSpinner&&clearInterval(this.timer),(0,n.createElement)("div",{className:"portfolio-page md-col-12"},(0,n.createElement)("div",{className:"portfolio-container"},1==this.state.showSpinner&&(0,n.createElement)("div",{className:"spinner-div",style:{top:"0",left:"0",width:"100%",height:"100%"}},(0,n.createElement)("img",{src:p,style:{margin:"0px auto"},alt:"Spinner"})),(0,n.createElement)("div",{style:{visibility:this.state.showSpinner?"hidden":"visible"}},this.createRows())))}}for(var d=f,m=document.getElementsByClassName("portfolio-block"),h=0;h<m.length;h++)c().render((0,n.createElement)(d,null),m.item(h));(0,i.registerBlockType)(u.u2,{edit:function({attributes:e,setAttributes:t}){return t({yourId:(0,l.useBlockProps)().id}),(0,n.createElement)("p",{...(0,l.useBlockProps)()},(0,a.__)("Portfolio Page","portfolio-block"))}})}},r={};function n(e){var o=r[e];if(void 0!==o)return o.exports;var i=r[e]={exports:{}};return t[e](i,i.exports,n),i.exports}n.m=t,e=[],n.O=function(t,r,o,i){if(!r){var s=1/0;for(u=0;u<e.length;u++){r=e[u][0],o=e[u][1],i=e[u][2];for(var c=!0,a=0;a<r.length;a++)(!1&i||s>=i)&&Object.keys(n.O).every((function(e){return n.O[e](r[a])}))?r.splice(a--,1):(c=!1,i<s&&(s=i));if(c){e.splice(u--,1);var l=o();void 0!==l&&(t=l)}}return t}i=i||0;for(var u=e.length;u>0&&e[u-1][2]>i;u--)e[u]=e[u-1];e[u]=[r,o,i]},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,{a:t}),t},n.d=function(e,t){for(var r in t)n.o(t,r)&&!n.o(e,r)&&Object.defineProperty(e,r,{enumerable:!0,get:t[r]})},n.g=function(){if("object"==typeof globalThis)return globalThis;try{return this||new Function("return this")()}catch(e){if("object"==typeof window)return window}}(),n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e;n.g.importScripts&&(e=n.g.location+"");var t=n.g.document;if(!e&&t&&(t.currentScript&&(e=t.currentScript.src),!e)){var r=t.getElementsByTagName("script");if(r.length)for(var o=r.length-1;o>-1&&!e;)e=r[o--].src}if(!e)throw new Error("Automatic publicPath is not supported in this browser");e=e.replace(/#.*$/,"").replace(/\?.*$/,"").replace(/\/[^\/]+$/,"/"),n.p=e}(),function(){var e={826:0,431:0};n.O.j=function(t){return 0===e[t]};var t=function(t,r){var o,i,s=r[0],c=r[1],a=r[2],l=0;if(s.some((function(t){return 0!==e[t]}))){for(o in c)n.o(c,o)&&(n.m[o]=c[o]);if(a)var u=a(n)}for(t&&t(r);l<s.length;l++)i=s[l],n.o(e,i)&&e[i]&&e[i][0](),e[i]=0;return n.O(u)},r=self.webpackChunkteam_block=self.webpackChunkteam_block||[];r.forEach(t.bind(null,0)),r.push=t.bind(null,r.push.bind(r))}();var o=n.O(void 0,[431],(function(){return n(289)}));o=n.O(o)}();