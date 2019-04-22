#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class Account {
	private:
		static int count;//acc_num
		static double rate;
		string accno,accname;
		double balance;

	public:
		Account() {}
		Account(string accno,string name,double bal)
			:accno(accno),accname(name),balance(bal) {
		}
		void init(string accno,string name,double bal) {
			this->accno = accno;
			accname = name;
			balance = bal;
		}

		static void setCount(int c) {
			count = c;
		}

		static void setRate(double r = 1.5) {
			rate = r;
		}

		double getBalance() {
			return balance;
		}

		string getAccno() {
			return accno;
		}
		string getAccname() {
			return accname;
		}

		void deposit(int money) {
			balance+=money;
		}

		void countRateMoney() {
			balance+=balance*rate;
		}

		void draw(int money) {
			balance-=money;
		}

		void echo(int amount_in,int amount_out) {
			cout<<getAccno()<<" "<<getAccname()<<" ";
			deposit(amount_in);
			cout<<balance<<" ";
			countRateMoney();
			cout<<balance<<" ";
			draw(amount_out);
			cout<<balance<<" "<<endl;
		}

};

int Account::count = 0;//acc_num
double Account::rate = 0.01;
int main() {
	int i,t,acc_num,sum;
	double rate;
	int count,amount,amount_in,amount_out;
	string accno,name;
	double bal;

	cin>>rate>>acc_num;
	Account* acc = new Account[acc_num];
	Account::setCount(acc_num);
//	Account::setRate();
	for(i=0; i<acc_num; i++) {
		cin>>accno>>name>>bal>>amount_in>>amount_out;
		acc[i].init(accno,name,bal);
		acc[i].echo(amount_in,amount_out);
	}

	for(i=0,sum = 0; i<acc_num; i++) {
		sum +=acc[i].getBalance();
	}
	cout<<sum<<endl;

	return 0 ;
}

