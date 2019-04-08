#include <iostream>
#include <cstring>
#include <algorithm>
#include <math.h>
#include <iomanip>
using namespace std;

class CD {
	public:
		int type;//1-黑胶片，2-CD，3-VCD，4-DVD
		string name;
		int rental;//每天租金价格
		int state;//0是未出租，1是已出租

		CD() {};
		CD(int type,string name,int rental,int state)
			:type(type),name(name),rental(rental),state(state) {
		};

		void check() {

			switch(type) {
				case 1:
					cout<<"黑胶片";
					break;
				case 2:
					cout<<"CD";
					break;
				case 3:
					cout<<"VCD";
					break;
				case 4:
					cout<<"DVD";
					break;
			}

			cout<<"["<<name<<"]";
			string is_rent = (state)?"已出租":"未出租";
			cout<<is_rent<<endl;
		}

		void getRental(int day) {
			int money = day*rental;
			if(state) {
				cout<<"当前租金为"<<money<<endl;
			} else {
				cout<<"未产生租金"<<endl;
			}
		}



};


int main() {
	int i,n;
	int type;//1-黑胶片，2-CD，3-VCD，4-DVD
	string name;
	int rental;//每天租金价格
	int state;//0是未出租，1是已出租
	int op_code;
	cin>>n;


	for(i=0; i<n; i++) {
		cin>>type>>name>>rental>>state>>op_code;
		CD cd(type,name,rental,state);
		switch(op_code) {
			case 0: //表示查询操作
				cd.check();
				break;
			default: //非0则表示查询并且计算租金费用
				cd.check();
				cd.getRental(op_code);

		}

	}

	return 0;
}

