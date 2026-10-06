// Путь к Playwright задаётся переменной окружения PW (npx-установка, не глобальная).
const { chromium } = await import(process.env.PW || 'playwright');
import fs from 'fs';
const outFile = process.argv[2];
const pages = [['solutions','https://nvglobal.local/solutions/'],['pricing','https://nvglobal.local/pricing-matrix/'],['docs','https://nvglobal.local/docs/'],['privacy','https://nvglobal.local/privacy-policy/'],['blog','https://nvglobal.local/blog/'],['404','https://nvglobal.local/no-such-page-xyz/']];
const widths = [1920,1440,840,375];
const b = await chromium.launch();
const res = {};
for (const w of widths){
  const ctx = await b.newContext({ ignoreHTTPSErrors:true, viewport:{width:w,height:900} });
  for (const [name,url] of pages){
    const p = await ctx.newPage();
    try{
      await p.goto(url,{waitUntil:'networkidle',timeout:60000});
      await p.evaluate(()=>new Promise(r=>setTimeout(r,600)));
      const data = await p.evaluate(()=>{
        const out=[];
        document.querySelectorAll('body *').forEach(el=>{
          if(!el.offsetParent && getComputedStyle(el).position!=='fixed') return;
          const r=el.getBoundingClientRect();
          if(r.width<1&&r.height<1) return;
          const cs=getComputedStyle(el);
          out.push([el.tagName+'.'+(el.className||'').toString().trim().split(/\s+/).slice(0,2).join('.'),
            Math.round(r.x),Math.round(r.y+window.scrollY),Math.round(r.width),Math.round(r.height),
            cs.color,cs.backgroundColor,cs.fontSize]);
        });
        return {h:document.body.scrollHeight, els:out};
      });
      res[`${name}@${w}`]=data;
    }catch(e){ res[`${name}@${w}`]={err:e.message.split('\n')[0]}; }
    await p.close();
  }
  await ctx.close();
}
fs.writeFileSync(outFile, JSON.stringify(res));
console.log('снято:',Object.keys(res).length);
await b.close();
