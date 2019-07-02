#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class Member {

	protected:
		int id;
		string name;
		int mark;

	public:
		Member() {}
		Member(int _id,string _name,int _mark) {
			id = _id;
			name = _name;
			mark = _mark;
		}

		virtual void add(int money) {
			mark += money;
		}

		virtual int exchange(int num) {
			int mon;
			mon = num/100;
			mark = mark-mon*100;
			return mon;
		}

		virtual void echo() {
//			普通会员1001--John--444
			cout<<"普通会员"<<id<<"--"<<name<<"--"<<mark<<endl;
		}



};

class VIP :public Member {
		int add_radio;
		int exc_radio;


	public:
		VIP() {}
		VIP(int _id,string _name,int _mark,int a_radio,int e_radio) {
			id = _id;
			name = _name;
			mark = _mark;
			add_radio = a_radio;
			exc_radio = e_radio;
		}

		virtual void add(int money) {
			mark = mark + add_radio*money;
		}

		virtual	int exchange(int num) {
			int mon;
			mon = num/exc_radio;
			mark = mark - mon*exc_radio;
			return mon;
		}

		virtual	void echo() {
//			普通会员1001--John--444
			cout<<"贵宾会员"<<id<<"--"<<name<<"--"<<mark<<endl;
		}



};

int main() {

	Member *pm;

	int id;
	string name;
	int mark;
	int add_radio;
	int exc_radio;
	int money,exchange;

	cin>>id>>name>>mark;
	Member mem = Member(id,name,mark);
	pm = &mem;

	cin>>money>>exchange;
	pm->add(money);
	pm->exchange(exchange);
	pm->echo();

	cin>>id>>name>>mark>>add_radio>>exc_radio;
	VIP vip =  VIP(id,name,mark,add_radio,exc_radio);
	pm = &vip;

	cin>>money>>exchange;
	pm->add(money);
	pm->exchange(exchange);
	pm->echo();


	return 0 ;
}

