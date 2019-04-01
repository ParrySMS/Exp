#include <iostream>
#include <math.h>
#include <iomanip>
using namespace std;

class CAccount {
		double balance;
	public:
		long long account;
		string name;
		double getBal() {
			return balance;
		}

		void init(long long account,string name,double balance) {
			this->account = account;
			this->name = name;
			this->balance = balance;
			showBal();
		}

		void showBal() {
			cout<<fixed<<setprecision(0);
			cout<<name<<"'s balance is "<<getBal()<<endl;
		}

		void save(double money) {
			balance +=money;
			cout<<"saving ok!"<<endl;
			showBal();
		}

		void withdraw(double money) {
			if(money>balance) {
				cout<<"sorry! over limit!"<<endl;
			} else {
				balance -=money;
				cout<<"withdraw ok!"<<endl;
			}
			showBal();
		}
};


int main() {
	const int NUM_OF_DEP = 2;
	int i=0;
	double balance;
	long long account;
	string name;
	double money;
	CAccount* ca = new CAccount[NUM_OF_DEP];
	for(i=0; i<NUM_OF_DEP; i++) {

		cin>>account>>name>>balance;
		ca[i].init(account,name,balance);

		//save
		cin>>money;
		ca[i].save(money);

		//withdraw
		cin>>money;
		ca[i].withdraw(money);
	}

	delete [] ca;
	ca = NULL;
	return 0;
}
