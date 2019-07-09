#include <iostream>
using namespace std;
class ACC {
	protected:
		long account;
		string name;
		float bal;
	public:
		ACC() { }
		ACC(long acc,string n,float b) {
			account = acc;
			name = n;
			bal = b;
		}

		void deposit(float mon) {
			bal += mon;
			cout<<"saving ok!"<<endl;
			echo();
		}

		virtual void withdraw(float mon) {
			if(mon>=bal) {
				cout<<"sorry! over balance!"<<endl;
			} else {
				bal -= mon;
				cout<<"withdraw ok!"<<endl;
			}
			echo();
		}

		void echo() {
			cout<<"balance is "<<bal<<endl;
		}
};

class Credit: public ACC {
	protected:
		float limit;
	public:
		Credit() {	}
		Credit(long acc,string n,float b,float lim)
			:ACC(acc,n,b),limit(lim) {	}

		void withdraw(float mon) {
			if(mon>=(bal+limit)) {
				cout<<"sorry! over limit!"<<endl;
			} else {
				bal -= mon;
				if(bal<0) {
					limit += bal;
					bal = 0;
				}
				cout<<"withdraw ok!"<<endl;
			}
			echo();
		}
};
int main() {
	long account;
	float mon;
	string name;
	float bal,limit;

	cin>>account>>name>>bal;
	ACC a(account,name,bal);
	a.echo();

	cin>>mon;
	a.deposit(mon);
	cin>>mon;
	a.withdraw(mon);

	cin>>account>>name>>bal>>limit;
	Credit c(account,name,bal,limit);
	c.echo();

	cin>>mon;
	c.deposit(mon);
	cin>>mon;
	c.withdraw(mon);

	return 0;
}


