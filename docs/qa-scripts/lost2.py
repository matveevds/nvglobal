import io,re,sys,subprocess

def strip_comments(s):
    return re.sub(r'/\*.*?\*/','',s,flags=re.S)

def selectors(css):
    """Все селекторы верхнего уровня И внутри @media/@supports."""
    css = strip_comments(css)
    out=set()
    i=0; buf=''
    stack=[]
    while i < len(css):
        c=css[i]
        if c=='{':
            sel=buf.strip()
            if sel.startswith('@'):
                stack.append('at')
            else:
                for s in sel.split(','):
                    s=re.sub(r'\s+',' ',s.strip())
                    if s: out.add(s)
                stack.append('rule')
                # пропустить тело правила
                depth=1; i+=1
                while i<len(css) and depth:
                    if css[i]=='{':depth+=1
                    elif css[i]=='}':depth-=1
                    i+=1
                stack.pop(); buf=''; continue
            buf=''
        elif c=='}':
            if stack: stack.pop()
            buf=''
        else:
            buf+=c
        i+=1
    return out

def section(css,name):
    m=re.search(r'/\*\s*'+name+r'\s+START\s*\*/(.*?)/\*\s*'+name+r'\s+END\s*\*/',css,re.S)
    return m.group(1) if m else None

cur=io.open('css/styles.css',encoding='utf-8').read()
cur_all=selectors(cur)

jobs=[('3851075','HERO'),('3851075','ABOUT'),('3851075','SOLUTIONS'),
      ('3851075','PRODUCTS'),('3851075','CLIENTS'),('3851075','DOC'),
      ('3851075','PRICING'),('3851075','RESULTS')]

prefixes={'HERO':['.hero'],'ABOUT':['.about'],'SOLUTIONS':['.solutions'],
 'PRODUCTS':['.products'],'CLIENTS':['.clients'],'DOC':['.doc'],
 'PRICING':['.pricing'],'RESULTS':['.results']}

for rev,name in jobs:
    old=subprocess.run(['git','show',f'{rev}:css/styles.css'],capture_output=True,text=True).stdout
    sec=section(old,name)
    if sec is None:
        print(f'{name}: секции не было в {rev}'); continue
    old_sel=selectors(sec)
    lost=sorted(s for s in old_sel if s not in cur_all)
    foreign=[s for s in lost if not any(p in s for p in prefixes[name])]
    print(f'{name}: потеряно {len(lost)}, ЧУЖИХ {len(foreign)}')
    for s in foreign: print('    !!',s)
