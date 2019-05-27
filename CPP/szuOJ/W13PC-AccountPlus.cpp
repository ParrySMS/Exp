#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class BaseAccount {
	protected:
		string name;
		string account;
		int balance;

	public:
		BaseAccount() {};
		BaseAccount(string _name,string _account,int _bal) {
			name = _name;
			account = _account;
			balance = _bal;
		}
		void init(string _name,string _account,int _bal) {
			name = _name;
			account = _account;
			balance = _bal;
		}

		virtual void deposit(int money) {
			balance += money;
		}

		virtual void withdraw(int money) {
			if(balance>=money) {
				balance -= money;
			} else {
				cout<<"insufficient"<<endl;
			}
		}

		virtual void display() {
			cout<<name<<" "<<account<<" Balance:"<<balance<<endl;
		}


};

class BasePlus:public BaseAccount {
	private:
		int limit = 5000;
		int limit_sum =0;
	public:

		BasePlus() {};
		BasePlus(string _name,string _account,int _bal)
			:BaseAccount(_name,_account,_bal) {
		}

		void deposit(int money) {
			balance += money;
		}

		void withdraw(int money) {
			if(balance>=money) {
				balance -= money;
			} else if((balance+limit)>=money) {
				limit_sum = (money - balance);
				limit -= limit_sum;
				balance = 0;
			} else {
				cout<<"insufficient"<<endl;
			}
		}

		void display() {
			cout<<name<<" "<<account<<" Balance:"<<balance;
			cout<<" limit:"<<limit<<endl;
		}

};


int main() {
	int t,i;
	string name;
	string account;
	int balance;
	int * num = new int[4];
	BaseAccount * acc;
	cin>>t;
	for(i=0; i<t; i++) {

		cin>>name>>account>>balance;

		if(account.find("BA") != string::npos) {
			acc = new BaseAccount(name,account,balance);
		} else {
			acc = new BasePlus(name,account,balance);
		}

		cin>>num[0]>>num[1]>>num[2]>>num[3];
		acc->deposit(num[0]);
		acc->withdraw(num[1]);
		acc->deposit(num[2]);
		acc->withdraw(num[3]);
		acc->display();
	}

	delete acc;

	return 0 ;
}


