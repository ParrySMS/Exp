#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class Account {
	private:
		int acc;
		char type;
		int bal;
		double radio = 0.005;
	public:
		int getAcc() {
			return acc;
		}
		char getType() {
			return type;
		}
		int getBal() {
			return bal;
		}
		Account() {}
		Account(Account* ac) {
			acc = 50000000 + ac->getAcc();
			type = ac->getType();
			bal = ac->getBal();
			radio = 0.015;
		}

		void init(Account* ac) {
			acc = 50000000 + ac->getAcc();
			type = ac->getType();
			bal = ac->getBal();
			radio = 0.015;
		}
		void init(int _acc,char _type,int _bal) {
			acc =_acc;
			type = _type;
			bal = _bal;
		}
		void option(char op) {
			double sum;
			string type_str;
			switch(op) {

				case 'C':
					//Account=12345678--sum=10050
					sum = bal*(1.0+radio);
					cout<<"Account="<<acc;
					cout<<"--sum="<<setiosflags(ios::fixed) <<setprecision(0)<<sum<<endl;
					break;
				case 'P':
					//Account=62345678--Person--sum=10000--rate=0.015
					cout<<"Account="<<acc;
					type_str = (type == 'E')?"Enterprise":"Person";
					cout<<"--"<<type_str;
					cout<<"--sum="<<bal;
					cout<<"--rate="<<setiosflags(ios::fixed) <<setprecision(3)<<radio<<endl;
					break;
			}
		}

};
int main() {
	int t,i,len;
	int acc;
	char type;
	int bal;
	char op1,op2;
	cin>>t;
	len = 2*t;
	Account * accs = new Account[len];
	for(i=0; i<t; i++) {
		cin>>acc>>type>>bal;
		accs[i].init(acc,type,bal);
		accs[t+i].init(&accs[i]);

		cin>>op1>>op2;

		accs[i].option(op1);
		accs[t+i].option(op2);
	}

	delete [] accs;
	return 0 ;
}


