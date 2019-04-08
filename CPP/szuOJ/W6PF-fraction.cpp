#include<cmath>
#include <iostream>
#include <stdio.h>
using namespace std;

int getGCD(int a,int b) { // 求对象的分子和分母的最大公约数
	if(a%b==0)
		return b;
	return getGCD(b,a%b);
}

class CFraction {
	public:
		int fz, fm;

		CFraction() {};
		CFraction(int fz, int fm):fz(fz),fm(fm) {};

		void add(const CFraction &r) {
			//通分
			int new_fm = fm*r.fm;

			int new_self_fz = fz*r.fm;
			int new_r_fz = r.fz*fm;

			//计算
			int new_fz = new_r_fz + new_self_fz;

			//约分
			int gcd = getGCD(new_fz,new_fm);
			new_fz /= gcd;
			new_fm /= gcd;

			if(new_fm<0 && new_fz<0
			        || new_fm<0 && new_fz>0 ) {
				new_fm *= -1;
				new_fz *= -1;
			}
			cout<<new_fz<<"/"<<new_fm<<endl;
		}

		void sub(const CFraction &r) {
			//通分
			int new_fm = fm*r.fm;

			int new_self_fz = fz*r.fm;
			int new_r_fz = r.fz*fm;

			//计算
			int new_fz = new_self_fz - new_r_fz ;

			//约分
			int gcd = getGCD(new_fz,new_fm);
			new_fz /= gcd;
			new_fm /= gcd;

			if(new_fm<0 && new_fz<0
			        || new_fm<0 && new_fz>0 ) {
				new_fm *= -1;
				new_fz *= -1;
			}


			cout<<new_fz<<"/"<<new_fm<<endl;
		}
		void mul(const CFraction &r) {
			int new_fm = fm*r.fm;
			int new_fz = fz*r.fz;

			//约分
			int gcd = getGCD(new_fz,new_fm);
			new_fz /= gcd;
			new_fm /= gcd;

			if(new_fm<0 && new_fz<0
			        || new_fm<0 && new_fz>0 ) {
				new_fm *= -1;
				new_fz *= -1;
			}
			cout<<new_fz<<"/"<<new_fm<<endl;
		}

		void div(const CFraction &r) {
			int new_fm = fm*r.fz;
			int new_fz = fz*r.fm;

			//约分
			int gcd = getGCD(new_fz,new_fm);
			new_fz /= gcd;
			new_fm /= gcd;

			if(new_fm<0 && new_fz<0
			        || new_fm<0 && new_fz>0 ) {
				new_fm *= -1;
				new_fz *= -1;
			}
			cout<<new_fz<<"/"<<new_fm<<endl;
		}

		void count(const CFraction &r) {
			add(r);
			sub(r);
			mul(r);
			div(r);
			cout<<endl;
		}
};



int main() {
	int i,t;
	int fz,fm;
	cin>>t;
	while(t--) {
		CFraction* cf = new CFraction[2];

		for(i=0; i<2; i++) {
			scanf("%d/%d",&fz,&fm);
//			fz"/">>fm;
			CFraction* cf_tmp = new CFraction(fz,fm);
			cf[i] = *cf_tmp;
//			delete cf_tmp;

		}

		cf[0].count(cf[1]);

		delete [] cf;

	}

	return 0;
}
