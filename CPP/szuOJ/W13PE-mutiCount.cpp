#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
#include <bits/stdc++.h>
using namespace std;
class Group {

	public:
		Group() {}
		virtual int add(int x, int y)=0;//输出加法的运算结果

		virtual int sub(int x, int y)=0;//输出减法的运算结果

};
class GroupA: public Group {

		int add(int x, int y) {
			return x+y;
		}

		int sub(int x, int y) {
			return x-y;
		}
};

class GroupB: public Group {

		int add(int x, int y) {
			return x+y;
		}

		int sub(int x, int y) {
			
			int tmp,base,res = 0;
			if(x<=y){
				tmp=x;
				x=y;
				y=tmp;
			}

			if((x%10) < (y%10)) {
				res = (x%10) + 10 - (y%10);
			} else {
				res = (x%10)  - (y%10);
			}

			for(base = 10; x/10!=0; base*=10) {
				x=x/10;
				y=y/10;
//				cout<<"x:"<<x<<"  "<<"y:"<<y<<endl;
				if((x%10) < (y%10)) {
					res += base * ((x%10) + 10 - (y%10));
				} else {
					res += base * ((x%10) - (y%10));
				}
			}
			return res;
		}
};


class GroupC: public Group {

		int add(int x, int y) {
			
			int tmp,base,res = 0;
			if(x<=y){
				tmp=x;
				x=y;
				y=tmp;
			}

			if((x%10) + (y%10)>=10) {
				res = (x%10) + (y%10) -10;
			} else {
				res = (x%10) + (y%10);
			}

			for(base = 10; x/10!=0; base*=10) {
				x=x/10;
				y=y/10;
//				cout<<"x:"<<x<<"  "<<"y:"<<y<<endl;
				if((x%10) + (y%10)>=10) {
					res += base * ((x%10) + (y%10) -10);
				} else {
					res += base * ((x%10) + (y%10));
				}
			}

			return res;
		}

		int sub(int x, int y) {
			int base,res = 0;

			if((x%10) < (y%10)) {
				res = (x%10) + 10 - (y%10);
			} else {
				res = (x%10)  - (y%10);
			}

			for(base = 10; x/10!=0; base*=10) {
				x=x/10;
				y=y/10;
//				cout<<"x:"<<x<<"  "<<"y:"<<y<<endl;
				if((x%10) < (y%10)) {
					res += base * ((x%10) + 10 - (y%10));
				} else {
					res += base * ((x%10) - (y%10));
				}
			}
			return res;
		}
};


int main() {

	int t,i,type,x,y;
	string counter,op,strx,stry;
	cin>>t;
	Group* g;
	for(i=0; i<t; i++) {
		cin>>type>>counter;

		switch(type) {
			case 1:
				g = new GroupA;
				break;
			case 2:
				g = new GroupB;
				break;
			case 3:
				g = new GroupC;
				break;
		}

		if(counter.find("+") != string::npos) {
			op ="+";
			strx.assign(counter,0,counter.find("+"));
			stry = counter.substr(counter.find("+")+1,-1);

		} else if(counter.find("-") != string::npos) {
			op ="-";
			strx.assign(counter,0,counter.find("-"));
			stry = counter.substr(counter.find("-")+1,-1);
		}

		stringstream ss; //流对象
		ss<<strx;
		ss>>x;
		ss.clear();
		ss<<stry;
		ss>>y;
//		cout<<"x:"<<x<<"  "<<"y:"<<y<<endl;

		if(op=="+") {
			cout<<g->add(x,y)<<endl;
		} else {
			cout<<g->sub(x,y)<<endl;
		}


	}
	return 0 ;
}


