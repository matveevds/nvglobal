// Поэлементный снимок принятых секций главной. Путь к Playwright — в PW.
const { chromium } = await import(process.env.PW || 'playwright');
import fs from 'fs';
const out = process.argv[2];
const SECTIONS = ['hero','about','results','solutions','products','clients','pricing','doc'];
const WIDTHS = [1920,1440,992,840,768,576,375];
const b = await chromium.launch({args:['--host-resolver-rules=MAP nvglobal.local 127.0.0.1,MAP www.nvglobal.local 127.0.0.1']});
const res = {};
for (const w of WIDTHS){
  const ctx = await b.newContext({ ignoreHTTPSErrors:true, viewport:{width:w,height:900} });
  const p = await ctx.newPage();
  await p.goto('https://nvglobal.local/',{waitUntil:'networkidle',timeout:60000});
  await p.evaluate(()=>new Promise(r=>setTimeout(r,1200)));
  res[w] = await p.evaluate((SECTIONS)=>{
    const o={};
    for(const s of SECTIONS){
      const root=document.querySelector('.'+s); if(!root){o[s]=null;continue;}
      const rr=root.getBoundingClientRect(); const top=rr.top+window.scrollY;
      const els=[];
      root.querySelectorAll('*').forEach(e=>{
        if(!e.offsetParent && getComputedStyle(e).position!=='fixed') return;
        const r=e.getBoundingClientRect(); if(r.width<1&&r.height<1) return;
        const c=getComputedStyle(e);
        els.push([e.tagName+'.'+(e.className||'').toString().trim().split(/\s+/).slice(0,2).join('.'),
          Math.round(r.x),Math.round(r.y+window.scrollY-top),Math.round(r.width),Math.round(r.height),
          c.color,c.backgroundColor,c.fontSize,c.borderRadius,c.borderWidth+' '+c.borderColor]);
      });
      o[s]={h:Math.round(rr.height),els};
    }
    return o;
  },SECTIONS);
  await ctx.close();
}
fs.writeFileSync(out,JSON.stringify(res));
console.log('снято ширин:',Object.keys(res).length);
await b.close();
