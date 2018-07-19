## 待开发

- seq辅助工具

- 允许添加保存存疑意见

- 图表类题目审核
    - 图片url
- 新数据结构（便于构建题库）
    - id、题目、选项、类目、答案、语言、题型、来源表、visible
    - id、proid、评论
    
- 数据增删查改后台

- 题库api


---------------

## 问题

#### 已查阅 logic-C,logic-E，
#### 未处理 -> {seq，verbal-C, verbal-CE, verbal-E}

0.xml标签不对齐
```xml
<Option>
    <A>3
    <B>4
    <C>5
    <D>6
</Option>
```

---------------

1.A选项标签当做了answer标签
```xml

 <Answer>
        3600  B:4800  C:6000  D:7200
    </Option>
    <Answer>
        A
    </Answer>
```   

---------------

2.中途其他字符插入，以及标签识别异常

```xml
<Classification>
    logic
</Hint>
```

```xml
<Data>
<Problem>
    一个粮食加工厂要运45000千克高粱，已经运到640袋，每袋63千克，还有多少千克没运到?
</Problem>
<Answer>
    4680  B:4780  C:4790  D:4690
    A :A
    C
    H :已经运了640*63=40320，还剩45000-40320=4680
</Hint>
</Data>
```

```xml
<Data>
<Problem>
    小明今年5岁，姐姐今年8岁，过10年以后，他们两人相差几岁？
</Problem>
<Option>
    <A>3
    <B>4
    <C>5
    <D>6
</Option>
<Answer>
    A
</Answer>
<Classification>

    H :8-5=3，十年后年龄差不变
</Hint>
</Data>

```

---------------

3.出现一些奇怪的字符`Q:`,初步估计是`、`和`.`,有些导致题目错乱

```xml
	<Problem>
			小红上学期期末考试，语文Q:数学Q:自然Q:社会Q:英语的成绩分别是88分Q:96分Q:94分Q:90分Q:82分。小红五科的平均成绩是多少？
		</Problem>
```

```xml
<Data>
		<Problem>
			小红12天看了170页书，小明17天看了240页书，小强20天看了300页书，谁看得快？
		</Problem>
		<Answer>
			小红  B:小明  C:小强  D:无法比较
		</Option>
		<Answer>
			C
		</Answer>
		<Classification>
			logic
		</Hint>
	</Data>

	<Data>
		<Problem>
			17  小明240/17=14Q:12  小强300/20=15，小强最快
		</Hint>
	</Data>
```

---------------

4.`</Classification> <Hint>` 丢失

```xml
<Data>
   <Problem>
       某人步行每小时4Q:8小时千米,骑自行车每千米比步行少用8Q:5分,骑车的速度是步行速度的多少倍?
   </Problem>
   <Answer>
       3.2
   </Answer>
   <Classification>
       logic
   </Hint>
   </Data>
```
  
```xml
   <Classification>
       logic
   </Hint>
```


---------------


5.题目录入异常,题号字符引起,题目切分错乱

```xml

<Data>
<Problem>
    甲、乙两站相距480公里，一列慢车从甲站开出，每小时行90公里，一列快车从乙站开出，每小时行140公里。两车同时开出，相背而行多少小时后两车相距600公里？
</Problem>
<Answer>
    12/23
</Answer>
<Classification>
    logic
</Classification>
<Hint>
    (140+90)x+480=600解这个方程，230x=120 ∴ x=
    （3）两车同时开出，慢车在快车后面同向而行，多少小时后快车与慢车相距600公里？
</Option>
<Answer>
    2.4
</Answer>
<Classification>
    logic
</Classification>
<Hint>
    (140－90)x+480=600　　 50x=120　　∴ x=2.4
    （4）两车同时开出同向而行，快车在慢车的后面，多少小时后快车追上慢车？
</Option>
<Answer>
    9.6
</Answer>
<Classification>
    logic
</Classification>
<Hint>
    140x=90x+480 　解这个方程，50x=480 　∴ x=9.6
    　　（5）慢车开出1小时后两车同向而行，快车在慢车后面，快车开出后多少小时追上慢车？
</Option>
<Answer>
    11.4min
</Answer>
<Classification>
    logic
</Classification>
<Hint>
    140x=90(x+1)+480　 50x=570　∴ x=11.4 　　
</Hint>
</Data>

```

```xml
	<Data>
		<Problem>
			0,1,3,5,7,()
		</Problem>
		<Answer>
			9
		</Answer>
		<Classification>
			sequence
		</Classification>
		<Hint>
			An=(n-1)2-(n-2)2
			109.1,2,5,16,65,?
			A,128；B,227；C,320；D,326
		</Option>
		<Answer>
			326
		</Answer>
		<Classification>
			sequence
		</Classification>
		<Hint>
			An+1=An*n+1
		</Hint>
	</Data>
```

---------------

6.题目的特殊符号以及部分式子内容丢失

```xml
<Hint>
    设她第一次在供销大厦买了x瓶酸奶，则  解，得x＝5
</Hint>

<Hint>
    ＋＝1　
    解这个方程，得x＝25
</Hint>

```

---------------
``
7.题目选项丢失

```xml
<Option>
    <A>
    <B>
    <C>
    <D>
</Option>

<Option>
			<A>
			<B>1
			<C>-1
			<D>-1
		</Option>
```


---------------
8.极小部分题目重复

---------------

9.选项标签未转化，有些选项在题目里

```xml
<Problem>
    南之于西北，正如西之于
    A西北?B东北?C西南?D东南
</Problem>

<Problem>
	1,1,2,6,24,?
	A,25；B,27；C,120；D,125
</Problem>

<Problem>
	√2,3,√28,√65,?
	A,2√14；B,√83；C,4√14；D,3√14
</Problem>

<Option>
		<A>178.5
		<B>179.5；C 180.5；D.181.5
</Option>
```


```xml
<Problem>
			甲安装队为A小区安装66台空调，
			乙安装队为B小区安装60台空调，
			两队同时开工且恰好同时完工，
			甲队比乙队每天多安装2台.
			设乙队每天安装x台，
			根据题意，下面所列方程中正确的是（  ）
			A.  B. C.   D
		</Problem>
```

---------------

10.问题标签异常 `Q;`

```xml

  //上一题的</Hint></Data>极大概率丢失

    Q;《故事大王》每本12元，《十万个为什么》每本25元，买8本《故事大王》和8本《十万个为什么》一共需要多少钱？
</Option>
<Answer>
    296  B:316  C:336  D:356
</Option>
<Answer>
    A
</Answer>
<Classification>
    logic
</Classification>
<Hint>
    8*12+8*25=296
</Hint>
</Data>
```

-------------

11.选择题答案出现选项内容
- 应该改成选项题号
```xml
<Data>
		<Problem>
			What character mask did Michael Myers wear?
		</Problem>
		<Option>
			<A>William Shatner
			<B>Fred Flintstone
			<C>Captain Kirk
			<D>Fred Williamson
			<E>Spock
			<F>Ronald Regan
		</Option>
		<Answer>
			Captain Kirk
		</Answer>
		<Classification>
			logic-commonsense
		</Classification>
		<Hint>
			
		</Hint>
	</Data>
```

---------------
12.seq填空项表述不一
- 不利于机器识别
```xml
<Problem>
			1/4,1/4 ,1/4 ,3/16 ,1/8 ,()
		</Problem>
```

```xml
<Problem>
			133/57 , 119/51 , 91/39 , 49/21 , ? , 7/3
		</Problem>

```

```xml
<Problem>
			1/6 2/3 3/2 8/3 ?
		</Problem>
```

------------

13.部分字符显示异常
```xml
<Data>
		<Problem>
			? + ? =
		</Problem>
		<Option>
			<A>1 ?
			<B>1 ?
			<C>1 ?
			<D>?
		</Option>
		<Answer>
			C
		</Answer>
		<Classification>
			logic-math
		</Classification>
		<Hint>
			
		</Hint>
	</Data>
```

----------------

14.标签化遗漏选项
```xml
<Option>
			<A>20
			<B>24
			<C>25
			<D>26 F.28
</Option>

<Option>
	<A>-16
	<B>-25；C；-28；D、-36
</Option>

```

---------------
15.带分数的显示有些奇怪
```xml
<Option>
			<A>3
			<B>4
			<C>4 1/2
			<D>5
			<E>6
		</Option>
```

-----------------
16.一个题目有多个问 可能不合理
```xml
<Data>
		<Problem>
			Simplify
			27 ???9  ???6
			74 37 17
			to the lowest fraction
		</Problem>
		<Answer>
			9
			17
		</Answer>
		<Classification>
			logical
		</Classification>
		<Hint>
			
		</Hint>
	</Data>
	
	
<Data>
		<Problem>
			下面这个方块中,最下面一行的数字应该是多少呢?
			
			7 4 9 2
			11 16 9 13
			22 20 24 25
			
		</Problem>
		<Answer>
			49 46 47 44
		</Answer>
		<Classification>
			sequence
		</Classification>
		<Hint>
			An=Cn-1+Dn-1
			Bn=An-1+Cn-1
			Cn=An-1+Dn-1
			Dn=Cn-1+Dn-1
		</Hint>
	</Data>
```

---------------
17.字符识别异常 可能是选项 以及提示出现url可能不利于识别
```xml
<Data>
		<Problem>
			The Strategic Defense Initiative (SDI) was proposed by U.S. President Ronald Reagan and became popularly known as "Star Wars"
			?    ??FACT  ??FICTION
		</Problem>
		<Answer>
			?FACT  ??
		</Answer>
		<Classification>
			logic-commonsense
		</Classification>
		<Hint>
			The program's goals included research and development of a space-based system to defend the nation from attack by strategic ballistic missiles
		</Hint>
	</Data>
```
```xml
<Data>
		<Problem>
			RMS Titanic was a British passenger liner that sank in the North Atlantic Ocean on 15 April 1912 after being struck by a torpedo from a German submarine
			??TRUE   FALSE
		</Problem>
		<Answer>
			?FALSE
		</Answer>
		<Classification>
			logic-commonsense
		</Classification>
		<Hint>
			It sank due to hitting an iceberg. Reference: http://en.wikipedia.org/wiki/Titanic
		</Hint>
	</Data>
```

```xml
<Data>
		<Problem>
			Which of the following is not one of the Seven Dwarfs?
			??Silly? ?Dopey? ?Sneezy? ?Doc
		</Problem>
		<Answer>
			?Silly? ?
		</Answer>
		<Classification>
			logic-commonsense
		</Classification>
		<Hint>
			
			546Question 2
			In what year did Lincoln deliver the Gettysburg Address?
			???1860?? 1861?? 1862 ??1863
		</Option>
		<Answer>
			?1863
		</Answer>
		<Classification>
			logic-commonsense
		</Classification>
		<Hint>
			
		</Hint>
	</Data>
```


---------------
18.选项前字符问题 数字出现`,`区分千位
```xml
       <Option>
			<A>?840
			<B>?960
			<C>?1,230
			<D>?1,360
			<E>?1,540
		</Option>
		<Answer>
        	?960
       	</Answer>
```

-------------
19.题目`<Problem>`或`<Hint>`里出现中文
```xml

        <Hint>
			365 每 73 = 292 days it will not rain, on 73 it will, therefore odds of 292:73 which simplifies to 4:1
		</Hint>
		
		<Hint>
   			1每 (1/2)2 = 3/4
        </Hint>
```

--------------
20. 标签不对齐
```xml
		<Answer>
			217
		</Classification>
```



## 待修复


0.xml标签不对齐 【半完成】 

写多一个xml标签检查,补前补后都要做
选项标签和其他标签都要对齐
```php
 //补选项标签
        if (strstr($itemStr1, '<' . $char . '>')) {//有开始标签 再读一行
            if (strstr($itemStr1, '</' . $char . '>')
                || strstr($itemStr2, '</' . $char . '>')
            ) {//如果本行或下一行有结束标签
               //var_dump($itemStr2);
                continue;
            } else {//确少标签 原有行补上
                //var_dump($itemStr1);
                $itemStr1 = $itemStr1 . '</' . $char . '>';
            }
        }
```

---------------

1.A选项标签当做了answer标签 

- 选项格式不统一，有半角全全角空格各类问题

```
<Answer>
    1  B、2  C、3  D、4
    或者  3600  B:4800  C:6000  D:7200
    或者  28  B.252  C. 264  D.378
    或者  8  B;252  C; 264  D;378
</Option>
```


```
<Option>
    <A>10
    <B>11  C 、12  D、13
</Option>

```

- 思路：

```xml
头大，目的是转成
<Option>
    <A>40</A>
    <B>41</B>
    <C>42</C>
    <D>43</D>
</Option>
```

----------------

2.中途其他字符插入 

- 思路： 
```xml
Lable:
Lable :
Lable  :
转为<Lable> 
之后再经过0.程序补齐一遍结束标签，
再人工审查编辑一遍.

```

-------------

3.奇怪的Q：

- 思路： 
```xml
if（ 数字 + Q: + 数字）--> .
else --> 、
 
题目切分错乱 人工修复
```

---------------

4.标签`</Classification> <Hint>` 丢失 

- 同0.程序自动补齐

---------------

5.题目切分问题

- 人工补齐

---------------

6.题目的特殊符号以及部分式子内容丢失

- 查阅word文档，用数字式人工添加
- 最好能够找到支持复杂数学公式的数据结构

----------------

7.题目选项丢失

- 查阅word文档人工添加

-------------

8.重复题目

- 修复完格式问题，程序筛别即可
- 同问题 同选项 同答案 同提示 判定为重复题目

-----------

9.选项标签未转化，选项在题目里

- 貌似只能人工先筛选，看下有没有规律，没有的话就在人工调整

-------------
10.问题标签异常 `Q;`

- logic 里只找到一个，需要再看下其他文件下是否有这个问题。

-------------
11.答案为选项内容

- 程序判断处理
```
if(in_array(answer,option)){
    option = answer->key
}
```