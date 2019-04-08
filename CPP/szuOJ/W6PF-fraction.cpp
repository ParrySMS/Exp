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
	private:
		int fz, fm;
//		static func1() {
//			cout<<"a static pri func"<<endl;
//		}

	public:
//		static func2() {
//			cout<<"a static pub func"<<endl;
//		}

		CFraction() {};
		CFraction(int fz, int fm) {
//			cout<<"CFraction(int fz, int fm) "<<endl;
//			cout<<"fz:"<<fz<<endl;
//			cout<<"fm:"<<fm<<endl;
			init(fz,fm);
		}

		void init(int fz, int fm) {
			// reduction of a fraction;
			int gcd = getGCD(fz,fm);
//			cout<<"gcd="<<gcd<<endl;

			fz /= gcd;
			fm /= gcd;

			// let fz show the signal
			if(fm<0 && fz<0
			        || fm<0 && fz>0 ) {
				fm *= -1;
				fz *= -1;
			}

			this->fz = fz;
			this->fm = fm;
		}

		/**	 ----------- [ ABOUT CFraction** ] ---------
		/*   res is addr of obj
		/*   p_res is addr of res
		/*   use p_res to change res to diff obj and free some obj Mem
		**/

		void add(const CFraction &r,CFraction** p_res) {

			if(* p_res) {
//				cout<<"delete [] * p_res; -- add"<<endl;
				delete [] * p_res;
			}
			//通分
			int new_fm = fm*r.fm;

			int new_self_fz = fz*r.fm;
			int new_r_fz = r.fz*fm;
			//计算
			int new_fz = new_r_fz + new_self_fz;

			* p_res = new CFraction(new_fz,new_fm);
//			cout<<"*p_res"<<*p_res<<endl;
		}


		void sub(const CFraction &r,CFraction** p_res) {
			if(*p_res) {
				delete [] *p_res;
			}
			//通分
			int new_fm = fm*r.fm;

			int new_self_fz = fz*r.fm;
			int new_r_fz = r.fz*fm;

			//计算
			int new_fz = new_self_fz - new_r_fz ;
			*p_res =  new CFraction(new_fz,new_fm);
		}

		void mul(const CFraction &r,CFraction** p_res) {
			if(* p_res) {
				delete [] * p_res;
			}
			int new_fm = fm*r.fm;
			int new_fz = fz*r.fz;
			* p_res = new CFraction(new_fz,new_fm);
		}

		void div(const CFraction &r,CFraction** p_res) {
			if(* p_res) {
				delete [] * p_res;
			}
			int new_fm = fm*r.fz;
			int new_fz = fz*r.fm;
			* p_res = new CFraction(new_fz,new_fm);
		}

		void echo(CFraction* cf) {
			if(cf) {
				cout<<cf->fz<<"/"<<cf->fm<<endl;
			} else {
				cout<<fz<<"/"<<fm<<endl;
			}
		}

		void count(const CFraction &r) {
			CFraction* res = NULL;

//			r.func1();
//			r.func2();

			add(r,&res);
			echo(res);

			sub(r,&res);
			echo(res);

			mul(r,&res);
			echo(res);

			div(r,&res);
			echo(res);

			if(res) {
				delete [] res;
				res = NULL;
			}

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
//			fz/fm;

			/** -- bad way
				CFraction* cf_tmp = new CFraction(fz,fm);
				cf[i] = *cf_tmp;
				delete cf_tmp;
			**/
			cf[i].init(fz,fm);

		}

		cf[0].count(cf[1]);

		delete [] cf;

	}

	return 0;
}
