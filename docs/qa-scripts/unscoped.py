import io,re,subprocess
exec(io.open(SP_LOST:='docs/qa-scripts/lost2.py',encoding='utf-8').read().split('cur=io.open')[0])

cur=io.open('css/styles.css',encoding='utf-8').read()
old=subprocess.run(['git','show','3851075:css/styles.css'],capture_output=True,text=True).stdout
cur_s=selectors(cur); old_s=selectors(old)

# НОВЫЕ селекторы, не ограниченные body.home и не принадлежащие только главной
home_only=('.about','.results__','.solutions__','.products','.clients',
           '.pricing','.doc__','.news','.cases','.promo','.video-intro',
           '.page-nav','.testimonials','.advantages','.contacts','.company',
           '.hero__','.results','.solutions')
added=sorted(s for s in cur_s if s not in old_s)
risky=[s for s in added if 'body.home' not in s and not any(p in s for p in home_only)]
print(f'Новых селекторов: {len(added)}; потенциально глобальных: {len(risky)}')
for s in risky: print('   ',s)
