#include <iostream>
using namespace std;
//成员函数实现
class Base {
	private:
		double num;
	public:
		double getNum() {
			return num;
		}
		Base() { }
		Base(Base &obj) { //拷贝构造
			num = obj.getNum();
		}

		Base(double n) {
			num = n;
		}
		//返回自己的引用
		Base& operator++() { //前增量 参数表空
			//函数目的是 先改值 后返回
			num+=0.1;
			return *this;
		}

		//返回一个对象值
		Base operator++(int) { //后增量 参数表int
			//函数目的是 先返回原值 然后再改值
			Base obj(*this);
			num+=0.1;
			return obj;
		}

};

int main() {
	Base b1(3.14),b2(6.66);
	cout<<(++b1).getNum()<<endl;

	Base b3((b2++).getNum());
	cout<<b3.getNum()<<endl;
	cout<<b2.getNum()<<endl;
//output:
//3.24
//6.66
//6.76
	return 0;
}
