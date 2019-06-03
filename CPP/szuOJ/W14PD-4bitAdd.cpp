#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class FourBit {
		int fourNum=0;
		int tenNum=0;
	public:
		FourBit() {}
		FourBit(int _data,int bit) {
			if(bit ==4) {
				fourNum = _data;
				four2Ten(_data);
			} else if(bit == 10) {
				tenNum = _data;
				fourNum = ten2Four(_data);
			}
		}

		FourBit(FourBit& a) {
			fourNum = a.getFourNum();
			tenNum = a.getTenNum();
		}

		void init(int four,int ten) {
			fourNum = four;
			tenNum = ten;
		}

		void init(int four) {
			fourNum = four;
			four2Ten(four);
		}

		friend void operator+=(FourBit&,FourBit&);

		void four2Ten(int four) {
			int base,div;
			int num = four%10;
			int res = num;
			for(base = 4,div=10; four/div!=0; base*=4,div*=10) {
				four = four/10;
				num = four%10;
				res += num*base;
			}
			tenNum = res;
		}

		int ten2Four(int data) {
			int num;
			if(data<4) {
				return data;
			} else {
				num = ten2Four(data/4);
				num*=10;
				num += data%4;
				return num;
			}
		}

		int getFourNum() {
			return fourNum;
		}

		int getTenNum() {
			return tenNum;
		}

};

void operator+=(FourBit& a,FourBit& b) {
	int ten = a.getTenNum() + b.getTenNum();
	int four = a.ten2Four(ten);
	a.init(four,ten);
}

int main() {
	int t,i;
	cin>>t;
	int* arr = new int[t];
	FourBit* fb = new FourBit[t];;
	for(i=0; i<t; i++) {
		cin>>arr[i];
		fb[i].init(arr[i]);
//		cout<<fb[i].getFourNum()<<endl;
//		cout<<fb[i].getTenNum()<<endl;
	}

	FourBit res(fb[0]);
	for(i=1; i<t; i++) {
		res += fb[i];
//		cout<<res.getFourNum()<<endl;
	}

	cout<<res.getFourNum()<<endl;

	return 0 ;
}

