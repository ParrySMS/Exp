
## 内测 DDL 8.20

## 待开发

- 图片切分（手工）

- seq 题目生成工具

- 允许添加保存存疑意见，编辑题目

- 图表类题目审核
    - 图片url
    
- 新数据结构（便于构建题库）
    - id、题目、选项、类目、答案、语言、题型、来源表、visible
    - id、proid、评论
    
- 数据增删查改后台

- 题库api

- 题目生成器


## 工作

### 分工时间表

#### 一、过存疑的第二遍，标注问题及修改建议

- 数据集审核

- 内部数据管理后台网站

#### 二、内测版本竞赛，竞赛平台搭建

- 竞赛平台网站

#### 三、移交测试模块、和运行模块

- OJ系统

#### 四、邀请人来比赛、测试

- 训练集生成（可能有变）

- 测试集生成（不可见）

- 规则制定

#### 五、跑通然后推上其他平台


**关键：数据集质量**

**参考：[SQuAD项目 https://rajpurkar.github.io/SQuAD-explorer/](https://rajpurkar.github.io/SQuAD-explorer/)**

---------------

## 问题

#### 已查阅 logic-C,logic-E，verbal-C,verbal-E, verbal-CE
#### 未处理 -> {seq后半部分}

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



<Classification>
			sequence
			H : An+1+An=Bn  ,Bn=2,6,18,54,162
		</Hint>

<Classification>
			sequence
			H :An+2=An+1+3^n
		</Hint>

```

---------------

3.出现一些奇怪的字符`Q:`,初步估计是`、`和`.`,有些导致题目错乱

```xml
	<Problem>
			小红上学期期末考试，语文Q:数学Q:自然Q:社会Q:英语的成绩分别是88分Q:96分Q:94分Q:90分Q:82分。小红五科的平均成绩是多少？
		</Problem>



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

4.`<Classification> <Hint>` 丢失

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


   <Classification>
       logic
   </Hint>
   
   
   <Classification>
       logic
   </Hint>
   
   
   <Answer>
   			2255
   		</Classification>
```


---------------


5.`</Hint>`与`</Data>`丢失,	`<Problem>标签成对丢失`,部分`<Option>丢失`,题目切分错乱

```xml


<Hint>
    (140+90)x+480=600解这个方程，230x=120 ∴ x=
    （3）两车同时开出，慢车在快车后面同向而行，多少小时后快车与慢车相距600公里？
</Option>



<Hint>
    (140－90)x+480=600　　 50x=120　　∴ x=2.4
    （4）两车同时开出同向而行，快车在慢车的后面，多少小时后快车追上慢车？
</Option>

<Hint>
    140x=90x+480 　解这个方程，50x=480 　∴ x=9.6
    　　（5）慢车开出1小时后两车同向而行，快车在慢车后面，快车开出后多少小时追上慢车？
</Option>



        <Hint>
			An+1=2An+An-12
			125.2,2,10,34,82,?
			
		<Option>
			<A>96
			<B>126
			<C>138
			<D>162
		</Option>

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
	
	
	
	<Data>
    		<Problem>
    			喜乐  之于  （  ）  相当于  （  ）  之于  美德
    		</Problem>
    		<Option>
    			<A>快乐 伦理
    			<B>情绪 诚信
    			<C>后悔 丑恶
    			<D>健康 心理
    		</Option>
    		<Answer>
    			情绪 诚信
    		</Answer>
    		<Classification>
    			verbal
    		</Classification>
    		<Hint>
    			function Belong
    			43. Q@ $ @ && @ $
    		<Option>
    			<A>$ @ $ && $ @
    			<B>& $ & @ @ & @
    			<C>@ && $ $ @ @
    			<D>@ $ @ @ && $
    		</Option>
    		<Answer>
    			$ @ $ && $ @
    		</Answer>
    		<Classification>
    			verbal
    		</Classification>
    		<Hint>
    			第一、三、六位置上是相同符号，二、七位置上符号相同，四、五位置上符号相同
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

7.题目、选项标签、题号标签以及内容、答案 部分丢失

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
		
		
		 <Data>
        		<Problem>
        			科学:技术（　　）
        		</Problem>
        		<Answer>
        			<!--丢失-->
        		</Answer>
        		<Classification>
        			verbal
        		</Classification>
        		<Hint>
        			Function()
        		</Hint>
        </Data>
        
        
        
         <Data>
        		<Problem>
        			<!--丢失-->
        		</Problem>
        			<!--选项丢失-->

        		<Answer>
        			<!--丢失-->
        		</Answer>
        		<Classification>
        			verbal
        		</Classification>
        		<Hint>
        			function
        		</Hint>
        	</Data>
```

```xml
	<Problem>
			沙粒之于真猪，相当于（）之于（）
		</Problem>
		<Option>
			<A>松脂:琥珀　　
			<B>恐龙:化石　　
			<C>珊瑚:珊瑚礁　　
			<D>玻璃:水晶
		</Option>
		<Answer>
			
		</Answer>
```


---------------
8.极小部分题目重复
```xml

<Data>
		<Problem>
			16,27,16,?,1
		</Problem>
		<Option>
			<A>5
			<B>6
			<C>7
			<D>8
		</Option>
		<Answer>
			5
		</Answer>
		<Classification>
			sequence
		</Classification>
		<Hint>
			An=(n+1)5-n
		</Hint>
	</Data>

```

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

<Option>
			<A>7
			<B>9 C,11 D.13
</Option>


        <Problem>
			甲安装队为A小区安装66台空调，
			乙安装队为B小区安装60台空调，
			两队同时开工且恰好同时完工，
			甲队比乙队每天多安装2台.
			设乙队每天安装x台，
			根据题意，下面所列方程中正确的是（  ）
			A.  B. C.   D
		</Problem>
		
<Data>
		<Problem>
			2,9,45,? ,891
			A,52 B,49 C,189 D,293
		</Problem>
		<Answer>
			189
		</Answer>
		<Classification>
			sequence
		</Classification>
		<Hint>
			An=3n-1*Bn
			Bn为质数列
		</Hint>
</Data>
	
	
	

<Problem>
			选项ABCD中,哪一个应该填在"XOOOOXXOOOXXX"后面?
			A?XOO?B?OO?C?OOX?D?OXX?
</Problem>



<Problem>
			16 (96) 12?10 ? 7.5
</Problem>


<Problem>
			填上空缺的字母?CFI?DHL?EJ?
</Problem>

		
		
```

---------------

10.问题标签异常 `Q;` `Q`

```xml

 <!--上一题的</Hint></Data>极大概率丢失-->

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




		<Classification>
			sequence
		</Classification>
		<Hint>
			An = n^Bn  ,Bn=4,3,2,1,0,-1
			<!--上一题的内容突然丢失-->
			Q68 (),36,19,10,5,2
		<Option>
			<A>77
			<B>69
			<C>54
			<D>48
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

<Problem>
			133/57 , 119/51 , 91/39 , 49/21 , ? , 7/3
		</Problem>


<Problem>
			1/6 2/3 3/2 8/3 ?
		</Problem>
		
<Problem>
    	√5 ,√55 ,11√5 ,11√55 ,(?)
</Problem>

<Problem>
		-3 ,-2 ,5 ,24 ,61 ,(  )
</Problem>

<Problem>
			63,26,7,0,-2,-9 ?
</Problem>

<Problem>
			129 107 73 17 -73 ( ?)
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
	

// seq里的内容
<Data>
		<Problem>
			2,3,28,65,?
		</Problem>
		<Option>
			<A>214
			<B>83
			<C>414
			<D>314
		</Option>
		<Answer>
			414
		</Answer>
		<Classification>
			sequence
		</Classification>
		<Hint>
			依次除以,2,3,4,5,6,都能整除
		</Hint>
	</Data>
	
	
	
        <Option>
			<A>凡?高——呐喊　　　
			<B>尼采——子夜　　
			<C>拉斐尔——茶馆　　　　
			<D>但丁——祝福
		</Option>	
```

----------------

14.部分选项的标签缺漏 


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

<Option>
			<A>658
			<B>478 .C556 D.581
</Option>

<Option>
			<A>1
			<B>√2 C√3 D.4
</Option>	

<Option>
			<A>8
			<B>13
			<C>21
			<D>26 F.31
</Option>


<Option>
			<A>33
			<B>35；C；47；D、53
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
16.一个题目有多个问 可能不合理 导致回答匹配情况不一


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

<Data>
		<Problem>
			7,5,3,10,1,?,?
		</Problem>
		<Option>
			<A>15、 -4
			<B>20、 -2
			<C>15、 -1
			<D>20、 0
		</Option>
		<Answer>
			20,0
		</Answer>
		<Classification>
			sequence
		</Classification>
		<Hint>
			A2n+1=A2n-1-23-n
			A2n=A2n-2*2
		</Hint>
</Data>


<Data>
		<Problem>
			根据下面各组数字的规律,问号应该代表什么数字?
			2  6  30  ?
			3  5  11  ?
		</Problem>
		<Answer>
			330与41
		</Answer>
		<Classification>
			sequence
		</Classification>
		<Hint>
			An,n*An+1,n=An,n+1  An,n+An+1,n=An+1,n+1
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
`
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
	
	
	
	
	<Problem>
    			1?3?2?4?6?5?7?()
    </Problem>
    
    <Problem>
    			961?(25)?432?932???731
    </Problem>
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

--------------
21. 有些提示对于机器而言过于抽象


```xml
	<Data>
		<Problem>
			1.1 ,2.2 ,4.3 ,7.4 ,11.5 ,?
		</Problem>
		<Option>
			<A>15.5
			<B>15.6
			<C>17.6
			<D>16.6
		</Option>
		<Answer>
			16.6
		</Answer>
		<Classification>
			sequence
		</Classification>
		<Hint>
			将小数与整数分开来看
		</Hint>
	</Data>

	<Data>
		<Problem>
			34. 0.75 ,0.65 ,0.45 ,?
		</Problem>
		<Option>
			<A>0.78
			<B>0.88
			<C>0.55
			<D>0.96
		</Option>
		<Answer>
			0.55
		</Answer>
		<Classification>
			sequence
		</Classification>
		<Hint>
			能被 0.05 除尽
		</Hint>
	</Data>
```

------------
22. 选项后出现逗号

```xml

<Option>
			<A>10,
			<B>14,
			<C>25,
			<D>30
		</Option>

<Option>
			<A>2,
			<B>8/9,
			<C>5/16,
			<D>1/3
</Option>

```

-------------
23.部分提示有歧义

```xml
<Hint>
			An+1=An+n+1
		</Hint>
		
		
		<!-- 
		An+n+1 
		可能是 An + n + 1 
		可能是 A[n+n] + 1 
	    ....	
		-->
		 
```

-------------
24. 答案`<Answer>`标签为空

 ```xml

   	<Data>
   		<Problem>
   			Choosing the word which is the exact opposite of GULLIBLE
   		</Problem>
   		<Option>
   			<A>Incredulous
   			<B>Fickle
   			<C>Easy
   			<D>Stylish
   		</Option>
   		<Answer>
   			
   		</Answer>
   		<Classification>
   			verbal-antonym
   		</Classification>
   		<Hint>
   			
   		</Hint>
   	</Data>
```

-------------
25. 数学公式表达有歧义

```xml
        <Problem>
			日环食之于日全食，相当于2πR之于（）
		</Problem>
		<Answer>
			PIR2
	        <!--平方的表达不好-->
		</Answer>
```

--------------
26.题目部分缺失 导致逻辑不明

```xml
		<Problem>
			30之于月，相当于之于（）
		</Problem>
		<Answer>
			星期
		</Answer>
		
		
		
		<Problem>
			，之于。，相当于45之于（）
		</Problem>
		<Answer>
			90
		</Answer>		
		

```

---------------

27.`<Hint>`中出现多余内容`
```xml
        <Hint>
			function cause(phenomenon)
			Classification
		</Hint> 
```

---------------
28. `<Classification>`中出现其他标签导致错乱

```xml
        <Classification>
			verbal
		</Answer>
		<Classification>
			verbal
		</Classification>

```

---------------
29. `<Problem>`标签里的问号`?` 位置错误
```xml
		<Problem>
			根据下面这些数字的规律，问号代表什么数字呢？
			4 7 3 8 9 2
			9 0 2 5 1
			5 1 6 3 5 9
		</Problem>

```

---------------

30. `<Hint>`标签出现多余数字

```xml
 <Data>
		<Problem>
			醋:酸
		</Problem>
		<Option>
			<A>叶:绿
			<B>花:红
			<C>雪:白
			<D>雨:涝
		</Option>
		<Answer>
			C
		</Answer>
		<Classification>
			verbal
		</Classification>
		<Hint>
			C。根据题干，醋是酸的，雪是白的。而叶不一定是绿的，花也不一定都是红的，雨也不一定都会造成水涝灾害。故选C。
			1
		</Hint>
	</Data>

```

--------------
31. 缺失若干标签 只有一个hint
```xml
<Data>
		<Problem>
			因此没有所谓的强弱之分。故不选。
			1
		</Hint>
</Data>
```


-----------------------
32. 选项中有多余的空格

```xml
    <Option>
			<A>食 物
			<B>储 藏 罐
			<C>绘画风格
			<D>木 材
			<E>纺 织 品
		</Option>
```


---------------------
33. 提示中出现不便理解的内容,例如`P(n)`,用序号代替式子。

```xml
     <Data>
		<Problem>
			20 22 25 30 37 ?
		</Problem>
		<Answer>
			48
		</Answer>
		<Classification>
			sequence-reasoning
		</Classification>
		<Hint>
			An+1-An=P(n)
			<!--p(n)也要有公式表达-->
		</Hint>
	</Data>
	
	
	<Hint>
	    			An=N2-N1,An*2-1+An*2=2*n+2
    </Hint>
    
    
    <Hint>
    			19-5+1=15 ①   ②-①=21
    			49-19+(5+1)=36 ②   ③-②=49
    			109-49+(19+5+1)=85 ③   ④-③=70 （70=21+49）
    			-109+(49+19+5+1)=④   ④=155
    			=155+109-(49+19+5+1)=190
    </Hint>


	
	
```

-------------------

34. seq序列无提示可能有问题
```xml

<Data>
		<Problem>
			1 5 10 15 ?
		</Problem>
		<Answer>
			30
		</Answer>
		<Classification>
			sequence-reasoning
		</Classification>
		<Hint>

		</Hint>
	</Data>

```

-------------------

35. 题目中缺少需要填空的`？` 【只有这一个题出现】

```xml

<Data>
		<Problem>
			1 1 3 1 3 5 6
		</Problem>
		<Option>
			<A>1
			<B>2
			<C>4
			<D>10
		</Option>
		<Answer>
			C
		</Answer>
		<Classification>
			sequence-reasoning
		</Classification>
		<Hint>
			An*2-1+An*2=2^(n-1)
		</Hint>
	</Data>
```

-------------------------





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

```xml
<Answer>
    1  B、2  C、3  D、4
    或者  3600  B:4800  C:6000  D:7200
    或者  28  B.252  C. 264  D.378
    或者  8  B;252  C; 264  D;378
</Option>


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