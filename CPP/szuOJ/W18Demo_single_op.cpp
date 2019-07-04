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
