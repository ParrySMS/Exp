#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class Vehicle {
	protected:

		string no;//编号

	public:
		virtual void display()=0;//应收费用

		Vehicle() {	}
		Vehicle(string _no) {
			no = _no;
		}
		void init(string _no) {
			no = _no;
		}
};
class Car :public Vehicle {
	private:
		int num;
		int weight;
		int fee;
	public:
		Car() {}
		Car(string _no,int _num,int _weight)
			:Vehicle(_no),
			 num(_num),weight(_weight) {
			fee = num*8+weight*2;
		}

		void display() {
			cout<<no<<" "<<fee<<endl;;
		}
};

class Truck :public Vehicle {
	private:
		int weight;
		int fee;
	public:
		Truck() {}
		Truck(string _no,int _weight)
			:Vehicle(_no),
			 weight(_weight) {
			fee = weight*5;
		}

		void display() {
			cout<<no<<" "<<fee<<endl;;
		}
};


class Bus :public Vehicle {
	private:
		int num;
		int fee;
	public:
		Bus() {}
		Bus(string _no,int _num)
			:Vehicle(_no),
			 num(_num) {
			fee = num*3;
		}

		void display() {
			cout<<no<<" "<<fee<<endl;;
		}
};


int main() {
	int t,num,fee,weight;
	int i,type;
	string no;
	Vehicle *pv;
	cin>>t;
	for(i=0; i<t; i++) {
		cin>>type>>no;
		switch(type) {
			case 1://car
				cin>>num>>weight;
				pv = new Car(no,num,weight);
				break;
			case 2: //truck
				cin>>weight;
				pv = new Truck(no,weight);
				break;
			case 3://bus
				cin>>num;
				pv = new Bus(no,num);
				break;
		}
		pv->display();
	}
	
//	delete []pv;
	return 0 ;
}


