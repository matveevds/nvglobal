import io,re,subprocess
base='docs/qa-scripts/lost2.py'
exec(io.open(base,encoding='utf-8').read().split('cur=io.open')[0])

def rules(css):
    """selector -> list of (context, body)"""
    css=strip_comments(css)
    res={}
    def walk(s,ctx):
        i=0;buf=''
        while i<len(s):
            c=s[i]
            if c=='{':
                sel=buf.strip();buf=''
                depth=1;j=i+1
                while j<len(s) and depth:
                    if s[j]=='{':depth+=1
                    elif s[j]=='}':depth-=1
                    j+=1
                body=s[i+1:j-1]
                if sel.startswith('@'): walk(body,ctx+'|'+re.sub(r'\s+',' ',sel))
                else:
                    for x in sel.split(','):
                        x=re.sub(r'\s+',' ',x.strip())
                        if x: res.setdefault(x,[]).append((ctx,re.sub(r'\s+',' ',body.strip())))
                i=j;continue
            elif c=='}': buf=''
            else: buf+=c
            i+=1
    walk(css,'')
    return res

cur=rules(io.open('css/styles.css',encoding='utf-8').read())
old=rules(subprocess.run(['git','show','3851075:css/styles.css'],capture_output=True,text=True).stdout)

# селекторы, встречающиеся в шаблонах НЕ главной
import glob,os
other=[]
for f in glob.glob('*.php')+glob.glob('template-parts/*.php'):
    if os.path.basename(f) in ('main-page.php','index.php','main-page-video-autoplay.php'): continue
    other.append(io.open(f,encoding='utf-8',errors='ignore').read())
other='\n'.join(other)

changed=[]
for sel,v in old.items():
    if sel in cur and cur[sel]!=v:
        cls=re.findall(r'\.([A-Za-z0-9_-]+)',sel)
        if cls and all(re.search(r'[\s"\']'+re.escape(c)+r'[\s"\']',other) for c in cls):
            changed.append(sel)
print('ИЗМЕНЁННЫЕ правила для классов, присутствующих на других страницах:')
for s in sorted(changed): print('   ',s)
