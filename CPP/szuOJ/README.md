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