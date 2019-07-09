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


- 输出流控制填充 `cout`

```C++
    cout<<setiosflags(ios::left|ios::showpoint);  // 设左对齐，以一般实数方式显示
    cout.precision(5);       // 设置除小数点外有五位有效数字 
    cout<<123.456789<<endl;
    cout.width(10);          // 设置显示域宽10 
    cout.fill('*');          // 在显示区域空白处用*填充
    cout<<resetiosflags(ios::left);  // 清除状态左对齐
    cout<<setiosflags(ios::right);   // 设置右对齐
    cout<<123.456789<<endl;
    cout<<setiosflags(ios::left|ios::fixed);    // 设左对齐，以固定小数位显示
    cout.precision(3);    // 设置实数显示三位小数
    cout<<999.123456<<endl; 
    cout<<resetiosflags(ios::left|ios::fixed);  //清除状态左对齐和定点格式
    cout<<setiosflags(ios::left|ios::scientific);    //设置左对齐，以科学技术法显示 
    cout.precision(3);   //设置保留三位小数
    cout<<123.45678<<endl;


// setiosflags(ios::fixed)
// setprecision(1)
```

```
//输出结果
123.46
****123.46
999.123
1.235e+02
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


 - 静态 --- 本质：为了解决数据共享问题 
```C++
class StaticTest{
public:
    	StaticTest(int a, int b, int c);
    	void GetNumber();
     	void GetSum();
 		static void f1(StaticTest &s);// 静态方法
private:
    	int A, B, C;
    	static int sum; //静态成员
};
    
//静态要自己预先初始化，然后就会常驻内存，直到结束
    
int StaticTest::sum = 0;
//数据类型 类::变量 = 值
    
void StaticTest::f1(StaticTest &s){
	cout << s.A << endl;//静态方法属于类，不属于对象，不能直接调用对象的一般成员
	cout << sum <<endl;//但是可以调用同属于静态的东西

}
    
int main(){
    
	return 0;
}
    
```

- 友元 --- 允许外部有权访问 `private` 和 `protected`

```C++
class Box
{

private:
   double width;
   
public:
   double length; 
   void setWidth( double wid );
   
//声明有这个friend可以进来，但它不属于这个类，放哪里都行
friend void printWidth(Box box);
friend class SuperPaper;//类的方法都能进来

};
```

- 父子类的构造方法

构造方法不能被继承，创建子类的时候，本质上是先创建了父类，然后再进行拓展的。
所以，子类创建时，先执行父类的构造方法，然后再执行自己对应的构造方法。

如果子类显式调用了父类构造，则执行对应的父类构造，否则默认执行父类空参数构造。

当父类只写了有参构造时，子类必须显式调用，否则无法父类默认空构造，出现报错。

```C++
#include <iostream>
using namespace std;
class Animal{
	public:
		int weight,price;
		Animal(){};
		Animal(int w,int p)
			:weight(w),price(p){
				cout<<"animal--weight:"<<weight<<endl;
				cout<<"animal--price:"<<price<<endl;
		}
};

class Fish: public Animal{
	public:
	string name;
	Fish(int weight,int price,string _name) : name(_name), Animal(weight,price) {
		//初始化参数的方式显示调用 参数表顺序无关
		cout<<"fish name:"<<name<<endl;
		
	} 
};

int main() {
	Fish(50,6,"hwer");
	return 0;
}
```

- 父子类的析构方法

  先析构子类，再析构父类。

- 多继承

```C++
//派生类：继承类型 父类名
class Rectangle: public Shape{...} //继承一个

/** 继承类型
 * public: 默认继承 无private
 * protected：归入protected
 * private：归入private
**/

class Rectangle: public Shape, protected PaintCost{...}//继承多个

//继承的二义性解决

//法1: 写明调用的类
int main()
{    C c;//class C: public B, public A
     c.A::fun();	//子类.具体父类::父类方法
     c.B::fun(); 	
}

//法2：自己新定义 直接调用自己的
int main()
{    C c;//class C: public B, public A
     c.fun();	//子类的方法
}


//法3：虚继承 具体执行会去找（多态）只产生一个拷贝

class Cperson
{   string name;  };
class CStudent : virtual public CPerson
{   int stuNo;  };
class CTeacher : virtual public CPerson
{    string title;  };

class CStudentOnJob : public CStudent,public CTeacher
//继承的两个类都是虚继承 Cperson ，只会产生一个拷贝，无冲突
{   string research;};


```



<img src="D:\Dev\Exp\CPP\szuOJ\assets\zhitu-des\1562097445632.png" width="400" align=center />



- 虚函数 动态联编

  **虚函数底层是用this来实现的。**

  `普通成员函数`或`析构函数`可以声明成虚函数。

  `静态、内联、构造、友元、全局函数` 不能作虚函数。

  注意：**不要在构造函数和析构函数中调用虚函数**
  因为在构造函数中，对象还不完整，所以虚表指针可能还没初始化好，那么调用虚函数，就会发生未定义行为；
  因为在析构函数中，会将对象某些成员清理，那么对象也不完整，同理，会发生未定义行为。

  运行时多态：通过继承结合动态绑定获得。必须先设计一个类层次（继承/派生），然后在某些类中使用**虚函数**。

  ```C++
  
  class Base{
      public:
    		virtual int add(int x){
        //virtual  <函数返回类型> <函数名>(<参数表>)
        	return x+5;
    		}  
  };
  
  class Counter: public Base{
    int add(int x){
        //这就就是虚函数，不加vitual也是，重新实现了也是
        //可根据具体的调用者的值，来确定执行哪个函数。
    }  
  };
  
  ```

  ```C++
  class Animal
  { public:
      void virtual cry(){cout<<"I am animal"<<endl;}
  };
  
  class Dog:public Animal
  { public:
        void cry(){cout<<"I am a dog" <<endl;}
  };
  
  class Cat:public Animal
  { public:
     void cry(){cout<<"I am a cat" <<endl;}
  };
  
  int main()
  {   Animal animal;
  	Dog dog;
  	Cat cat;
   
     //基类可以被子类赋值，
  	animal=dog;
  	animal.cry();//虚函数多态，执行时确定调用，可以调用到子类的函数。否则没有虚函数会调用基类自己
  	animal=cat;
  	animal.cry();
   
     //基类对象指针 可以通过虚函数实现多态的调用
  	Animal *p_animal; //指针同理
  	p_animal=&dog;//创建了对象之后 再赋值给指针
  	p_animal->cry();
  	p_animal=&cat;
  	p_animal->cry();  
  
   }
  
  
  ```

- 多态

  - 编程多态：函数重载 overload，子类重写虚函数 override，运算符重载
  - 运行时多态：等到运行才能确定，继承+动态绑定实现。
  
- 纯虚函数：在基类中没有具体实现的虚函数，任何继承的子类都要自己定义该函数

- 抽象类：包含纯虚函数的类，不能实例化，专门被继承，可以定义指针或引用。

  ```C++
  class Animal         //抽象类
  {public:
    void virtual cry()=0;   //纯虚函数
  };
  
  ```
  
- 运算符重载： 通过函数实现
  
  只能重载已经存在的运算符，不改变原符的操作数个数、优先级、结合性。

	赋值运算符`=`不可继承，其他可以由子类继承
	
	下列运算符不能重载：
	
	- 作用域运算符`::`
	- 成员对象选择运算符`.*`
	- 类对象选择运算符`.`
	- 条件运算符`? :`

**实现运算符重载：类成员函数 or 友元函数**

```C++
class CComplex{
...
//类成员函数实现
    
//返回一个引用 重载+= 
 CComplex& operator+= (const CComplex &r_c){ 
    // 对象(左操作数) 重载符 参数(右操作数)
   real+=r_c.real;
   image+=r_c.image;
   return *this;  //成员函数有this指针 可以返回自己对象值
  }


  //友元函数实现
friend  CComplex& operator+= (CComplex &r_a,const CComplex &r_b){ 
    // 重载符 参数(左操作数，右操作数)
   r_a.real += r_b.real;
   r_a.image += r_b.image;
   return r_a;  //返回参数表的引用
  }
    
};

//使用方法： 
CComplex c1(1,2),c2(3,4),c3;
c3 = c1+=c2; 
c3+=c1;

```


- **一元运算符重载** ：这个分为前缀和后缀.

  `<op><params>` 称为前缀 ，`<params><op>` 称为后缀。

  ```c++
#include <iostream>
  using namespace std;
//成员函数实现
  class Base {
  	private:
  		double num;
  	public:
  		double getNum() const {
  			return num;
  		}
  		Base() { }
  		Base(const Base& obj) { //拷贝构造
  			num = obj.getNum();
  		}
  
  		Base(double n) {
  			num = n;
  		}
  		//返回自己的引用
  		Base& operator++() { //++i 前增量 参数表空
  			//函数目的是 先改值 后返回
  			num+=0.1;
  			return *this;
  		}
  
  		//返回一个对象值
  		Base operator++(int) { //i++后增量 参数表int
  			//函数目的是 先返回原值 然后再改值
  			Base obj(*this);
  			num+=0.1;
  			return obj;
  		}
  
  //友元函数实现
		//返回自己的引用
  		friend Base& operator--(Base& a) { //前增量 参数表为一个对象引用
			//函数目的是 先改值 后返回
  			a.num-=0.1;
			return a;
  		}
  
  		//返回一个对象值
  		friend Base operator--(Base & a,int) { //后增量 参数表 （一个对象引用,int）
			//函数目的是 先返回原值 然后再改值
  			Base obj(a);
			a.num-=0.1;
  			return obj;
		}
  
  };
  
  int main() {
  	Base b1(3.14),b2(6.66);
  
  	cout<<(b1++).getNum()<<endl; //3.14
  	cout<<b1.getNum()<<endl; //3.24
  
  	cout<<(b2--).getNum()<<endl; //6.66
  	cout<<b2.getNum()<<endl; //6.56
  
  	cout<<(++b1).getNum()<<endl; //3.34
  	cout<<(--b2).getNum()<<endl;//6.46
  
  	Base b3((b2++)); 
  	cout<<b3.getNum()<<endl; //6.46
  	
  	cout<<b2.getNum()<<endl; //6.56
  	return 0;
  }
  ```
  
- 隐式类型转化
  对象类型的参数，其他类型会**尝试调用构造函数**进行自动的对象生成来进行类型转化
  
- 显式类型转换-**类型运算符重载**
  自定义重载的类型，进行特殊的转化。注意空参数，返回一个指定类型数据。
  
  `operator 类型名(){ return 类型数据 }` 
  
  ```C++
  #include<iostream>
  using namespace std;
  class USD;//先声明一下
  class RMB
  {      int yuan,jiao,fen;
   public:  
         RMB(）{}
         RMB(int y=0,int j=0,int f=0):yuan(y),jiao(j),fen(f){}
         operator double(){ //类型运算符重载 自定义
             return yuan+0.1*jiao+0.01*fen;
         }
         operator int();{ //类型运算符重载 自定义
             return yuan;
         }
         operator USD(); //类型运算符 还能转对象
             //转美元对象 这个函数要放在类外实现 放在USD定义之后
  };
             
  class USD {//实现一个美元类
  		int dollar,cent;
  	public:
  		USD(){}
  		USD(int d,int c):dollar(d),cent(c){	}
      	echo(){
  			cout<<"UDS:"<<dollar<<"."<<cent<<endl;
  		} 
  };
             
  const double R2U = 0.1527;           
  RMB::operator USD(){//定义类的重载
      double usd = (yuan+0.1*jiao+0.01*fen)*R2U;
      int dollar = (int)usd;
      int cent = 100* (uds - dollar);
      return USD(dollar,cent);
  }       
  
  //实际使用  
  int main() {
  	RMB r(13,22,13);//一个对象
  	double d=r;
  	cout<<"double:"<<d<<endl;
  	int t=r;
  	cout<<"int"<<t<<endl;
  	USD u = r1;//直接用对象赋值
  	u.echo();
  	return 0;
  }
  ```

- I/O运算符重载

自己定义 一个 ostream 的对象的引用，则也可以直接使用运算符 `<<`

定义 一个 istream 的对象的引用，也可以直接使用运算符 `>>`

** 只能使用友元重载，因为左操作数是**流引用**，右操作数是**类引用**，应该**返回一个流引用**

  ```C++
//  << 输出 引用传递一个类 加const可保持不被改
friend ostream & operator << (ostream & stream, const  类名 &obj )
{        // 函数体 
    return stream;
}

// >> 输入 赋值到类里
friend istream & operator >> ( istream &stream, 类名  &obj )
{          // 函数体
	return stream;
}
  ```
```C++
  //Date类示例
#include<iostream>
using namespace std;

class Date {
	private:
		int y, m ,d;
	public:
		Date(int y,int m,int d):y(y),m(m),d(d) {}
		friend ostream& operator<<(ostream &stream,Date &date);
		friend istream& operator>>(istream &stream,Date &date);
};
//友元函数实现 
ostream& operator<<(ostream &stream,Date &date) {
	stream<<date.y<<"/"<<date.m<<"/"<<date.d<<endl;
    //不是用cout 是用传进来的流进行io操作
	return stream;
}

istream& operator>>(istream &stream,Date &date) {
	stream>>date.y>>date.m>>date.d;//类引用 直接赋值进private
	return stream;
}

int main( ) {
	Date Cdate(2004,1,1);
    //外部调用就用 cout cin 流，直接 <<类 或者 >>类
	cout<<"Current date:"<<Cdate<<endl;
	cout<<"Enter new date:";
	cin>>Cdate;
	cout<<"New date:"<<Cdate<<endl;
}
```

- 赋值运算符 `=` 重载
  
  采用浅复制方式，直接修改当前对象并把当前对象当作返回结果
  
  声明对象初始化，会调用拷贝构造函数
  
```c++
//类成员重载
Complex operator =(const Complex& c)
{   
	real=c.real;             
	image=c.image;  
	return *this;        
} 
```

- 下标运算符 `[ ]` 重载

```c++
//类成员函数实现
int& operator[ ](int index){
//为了能被赋值 所以返回int引用 作为一个地址空间
  if((index<0)||(index>SIZE-1)){
     cout<<"Index out of bounds\n";
     exit(0);
  }
  return ar[index]；
}

```

- 函数调用 `()` 重载

```C++
#include<iostream>
using namespace std;
class F{  
public:
//类成员函数实现
   double operator ()(double x, double y) const
   {   return   2*x+y;   }
}；

int main()
{   F f;
  cout<<f(1.5, 2.2)<<endl;
  return 0;
}

```

- new和delete的重载
希望使用某种特殊的动态内存分配方法
// todo:

- 类函数模板
```C++
template<class TYPE> //把可变的部分变为一个指定的 <class T>
// 也可以使用多个函数模板 template <class T,class D>
//具体实现
void print( const TYPE ar[], int size){
   int i;
   for(i =0; i<size-1; i++){
    cout<<ar[i]<<", ";
   }
   cout<<ar[i]<<endl;
}

//函数模板里不知道隐式转化 所以char和int是两种类型 只会根据类型来匹配
template<class TYPE1,class TYPE2>
TYPE1 max(TYPE1 a, TYPE2 b){
	return (a>b)? a:b;
}

//调用 
max(76,'A')；
// int char ---> return int , char自己运算中强转int
```
- 类模板
一样的，在类里面用自定义的 TYPE,实例化的时候加多一个<类型列表>

```C++
template<class  TYPE>  //可以多个TYPE <class T1,class T2>
//类模板的实现
class List{ 
    TYPE* vector;
     int size;
public:
         List (int length) {                            //构造函数
          vector=new TYPE[length];
          size=length;
      }
      ~List( ) { delete [ ] vector;  }              //析构函数
　 TYPE& operator[ ](int index) {
          return vector[index];  
      }
};

//实例化的声明
List<int> ar(10); // 声明一个int类的List对象 ar，调用构造函数
List<double> ar_double;

```

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

---------------------


​	