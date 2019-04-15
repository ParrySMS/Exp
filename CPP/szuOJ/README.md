- 二维矩阵
```C++

//init
int **line = new int*[m]();
for(i=0; i<m; i++) {
	line[i] = new int[n];
}

//load
	int *data_p = *(line+i) + j ;
	int data = line[i][j];
	
//foreach - 1 两循环
for(i=0; i<m; i++) {
	for(j=0; j<n; j++) {
		cout<<line[i][j]<<endl;
	}
}

//foreach - 2 指针单循环
int *p = line[0][0];
for(i=0; i<m*n; i++) {
	cout<<*p<<endl;
	p++;	
}


//free
	
for(i = 0; i < n; i++) {
	delete[] line[i];
}
delete [] line;

```

- 小数位数控制输出

```C++
#include <iomanip>

cout<<setiosflags(ios::fixed) <<setprecision(1)<<min<<endl;
```



- 奇奇怪怪的OJ 使用不了strupr, 用这个方法转化大小写

```C++
#include <cctype>

char* upper(char * str) {
//	return strupr(str);
	char *orign=str;
	for (; *str!='\0'; str++)
		*str = toupper(*str);
	//	 *str = tolower(*str);
	return orign;

}

```

- 字符数组输出

```C++
char *res = new char[35];
cout<<res<<endl; //首地址即可输出全部

```


- 输出数字填充

```C++
cout.fill('0');//设置填充字符
cout.width(4);//设置位宽
cout<<m<<"/";// m = 6 ,输出 0006
```

- 数据实体用 `.` ,指针用 `->`

```C++
class Point {
		int x = 0;
		int y = 0;
	public:
		Point() {};
		Point(int x,int y) {
			this->x = x;
			this->y = y;
		}
		void output() {
			cout<<"point "<<x<<" "<<y<<endl;
		}
};

```


```C++
Point *p_p1 = new Point(1,1);

p_p1->output();
(*p_p1).output();

Point p2(2,2);
Point *p_p2 = &p2;

(&p2)->output();
p_p2->output();

(*p_p2).output();
p2.output();

```

- 内存数据清空
```C++
#include <stdib.h>

//置空获取
int *pi = calloc(5,sizeof(int));

//获取 再置空
int *pi = malloc(5*sizeof(int));
memset(pi,0,5*sizeof(int));

int *pi = new int[5];
memset(pi,0,5*sizeof(int));
```

- 数组排序
```C++
#include <algorithm>

int ar[5] = {1,5,85,7,8}
//升序 从小到大
sort(ar,ar+5);

//标准库指定升序降序的方法
#include <functional>

sort(ar,ar+5,greater<int>()); //升序 从小到大 
sort(ar,ar+5,less<int>()); //降序 从大到小 


```

- 结构体排序
```C++
#include <algorithm>

typedef struct birth {
	int year;
	int month;
	int day;
} bir;


bool cmp(bir x,bir y){
	if(x.year!=y.year) 
		return x.year<y.year; //1或true 第一个参数x排在前面 
	if(x.month!=y.month) 
		return x.month<y.month;
	if(x.day!=y.day) 
		return x.day<y.day;
	
}

sort(bir_ar,bir_ar+t,cmp); //传递排序函数

//日期小的会在前 bir_ar[0]


```

- 构造函数 

不会返回任何类型，也不会返回 void

可以使用初始化列表来初始化字段
```C++

class Line
{
   public:
      void setLength( double len );
      double getLength( void );
      Line(double len);  // 这是构造函数
 
   private:
      double length;
};

Line::Line( double len): length(len) //参数len 赋值到 成员length
{
   ....
}

//上面的构造等同于：
Line::Line( double len)
{
    length = len;
     ....
}
 
C::C( type a, type b, type c): X(a), Y(b), Z(c)
//类名::类名构造函数( 类型 参数): 成员（参数)
{
  ....
}


```

- 析构函数 

它不会返回任何值，也不能带有任何参数。
析构函数有助于在跳出程序（比如关闭文件、释放内存等）前释放资源。

 ` ~Line();  // 这是析构函数声明 `

 - 对象数组赋值 小心匿名类造成内存泄露 应该用public函数做成员赋值

 ```C++
 
 class ACC {
	public:
		int card_no;
		int phone;
		int pw;
		int balance;
		ACC() {};
		ACC(int card_no,int phone,int pw,int balance)
			:card_no(card_no),phone(phone),pw(pw),balance(balance) {
		};
};

 	ACC * acc = new ACC[n];
	for(i=0; i<n; i++) {
		cin>>card_no>>phone>>pw>>balance;
		 
		acc[i] = *(new ACC(card_no, phone, pw, balance));
		
		/** --- bad way ---
		 *  this mean  tmp = new Obj ,then copy tmp to array. 
		 * The tmp var result in Mem leak.
		 */
	}	
 ```

- 静态引用以及指针函数参数

`func(const CFraction &r) ` 对象静态引用 引用传递 可读 r是外面的对象 可以调用private和静态方法

`func(CFraction* pr)` 指针参数 指针值传递 指针指向的空间可读可写 pr是外面传进来的地址值

`func(const CFraction* pr_c) ` 指向一个常量对象的指针 必须是常量的地址 目的是每次操作都操作同一对象常量 可读



- **string 类**  `#include <cstring>`

  string 并不是 C++ 的基本数据类型，它是 C++ 标准模板库中的一个类。

  

  - 定义以及初始化 

    ```c++
    //赋值
    string s1 = "hello"; 
    string s2("world"); 
    
    //字符数组
    char name[] = "Lady Gaga";
    string s1 = name;  //char数组复制内容到string 不影响原数组
    
    char* p_char = new char[10];
    string s2 = p_char; //char数组首地址
    
    
    //重复单字符
    string str(5,'a'); //"aaaaa";
    
    
    //截取赋值
    // 法1 :  string str(origin_str,start,len)  
    // 法2 :  str.assign(origin_str,start,len)  
    // 无len则后续全部[start....]
    
    string s1 = "hello"; 
    	
    string mid_part(s1,2,2); //"ll"  -- new 对象初始化
    string end_part(s1,1); //"ello"
    
    mid_part.assign(s2,0,3); // "wor" 没有new新对象
    end_part.assign(str); //相当于全复制
    
    ```

    

  - 读入

    ```C++
    cin>>str;
    getline(cin,str);
    ```

  

  - 遍历、迭代器、长度   `string::iterator`

    ```C++
    string str = "ParrySMS"
     
    //遍历1 用数字下标
    int len = str.size(); // or int len = str.length();
    for(int i=0;i<len;i++){
        cout<<str[i]<<" "; //'P' 'a' .....'S'
    }
    
    //遍历2 用迭代器
    string::iterator it;
    for(it=str.begin();it<s1.end();it++){
        cout<<*it<<" "; //类似于单元空间的一个指针
    }
    
    /** 位置指向说明
     *            P ....  S   M    S      '\0'
     *            0 ....          n-1    n = size() 
     *            begin() .. -->          end()
     *   rend()      <-- .....  rbegin()  
     */
     
    ```

  - 交换  `swap(str1,str2)`

    ```C++
    string s1 = "hello";
    string s2 = "world";
    swap(s1,s2);//以string为单位交换
    //s1="world"  s2="hello"
    ```

    

  - 插入  `insert(start,added_string)`

    ```C++
    string s1 = "hello";
    s1.insert(0,"world "); //s1 = "world hello"
    ```

  - 删除  `erase(start_index,len)` , `erase(it_start,it_end)---[start,end)` 

    ```C++
    str = "ABCDEFG HIJK LMN";
    str.erase(str.begin()+2,str.end()-7);
    //ABIJK LMN
    ```

    

  - 清空

    ```C++
    str.clear(); //变成空串
    str.~string()；//销毁  释放 Mem
    ```

    

  - 查找 ，替代

    ```C++
    string line = "this@ is@ a test string!";
    line = line.replace(line.find("@"),1,"");
    // 将line中 从find @ 位置 替换一个长度的字符为"" 
    // this is@ a test string!
    
    //是否找到  没找到目标就返回 npos
    if(s.find("jia") == string::npos) ...
    
    ```

  - 字符数组 string 数字 的 三者转化

    需要 `#include <bits/stdc++.h>` 或  `sstream`

    详见 [https://blog.csdn.net/Sophia1224/article/details/53054698](<https://blog.csdn.net/Sophia1224/article/details/53054698>)

    

    ```C++
    #include <cstring>
    #include <bits/stdc++.h>
    
    string str = "65";
    int x;
    stringstream ss; //流对象
    
    ss<<str; 
    ss>>x;
    cout<<"x "<<x<<endl;
    // x = 65
    
    
    ss.clear(); //注意string 和 stream 重复使用需要清空
    str.clear();
    
    int y = 101;
    ss<<y;
    ss>>str;
    cout<<"str "<<str<<endl;
    // str = "101"
    
    
    
    // char[] --> str  字符数组变string
    char ch [] = "ABCDEFG";
          string str(ch); 
    //or  string str = ch; 
    
    
    
    // str --> char[] string变字符数组
    string str = "ABCDEFG";
    	
    	//法1
    	char buf[50]; //0-49位
    	int end = str.copy(buf,49);// n-1位复制str str复制完了就补0
        buf[end] = '\0'; //末尾 50补0
    
    	//法2
         int len = str.size();
    	char* pbuf = new char[len+1];
        str.copy(pbuf,len);
        pbuf[len] = '\0';
    
    ```

    


​	