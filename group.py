from collections import Counter
stripJunk = str.maketrans("","","- ")
def getRatio(a,b):
    a = a.lower().translate(stripJunk)
    b = b.lower().translate(stripJunk)
    total  = len(a)+len(b)
    counts = (Counter(a)-Counter(b))+(Counter(b)-Counter(a))
    return 100 - 100 * sum(counts.values()) / total


data = ['MONTREAL EDUCATION BOARD', 'Ile de Montreal', 'Montreal',
       'Ville de Montreal', 'MONTREAL CITY', 'Monrteal', 'Mont-real',
       'Toronto', 'Toronto city', 'Tornoto', 'What is this', 'Bananasplit',
       'Banana', 'StLouis', 'St Louis', 'Saint Louis']

treshold     = 75
minGroupSize = 1

from itertools import combinations

paired = { c:{c} for c in data }
for a,b in combinations(data,2):
    if getRatio(a,b) < treshold: continue
    paired[a].add(b)
    paired[b].add(a)

groups = list()
ungrouped = set(data)
while ungrouped:
    bestGroup = {}
    for city in ungrouped:
        g = paired[city] & ungrouped
        for c in g.copy():
            g &= paired[c] 
        if len(g) > len(bestGroup):
            bestGroup = g
    if len(bestGroup) < minGroupSize : break  # to terminate grouping early change minGroupSize to 3
    ungrouped -= bestGroup
    groups.append(bestGroup)