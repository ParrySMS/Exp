#include <iostream>
using namespace std;

class Date {
	public:
		string year;
		string mon;
		string day;

		Date() {}
		Date(string y,string m,string d):year(y),mon(m),day(d) {}
		void echo() {

			cout<<year<<".";

			cout.fill('0');//ÉèÖÃÌî³ä×Ö·û
			cout.width(2);//ÉèÖÃÎ»¿í
			cout<<mon<<".";

			cout.fill('0');//ÉèÖÃÌî³ä×Ö·û
			cout.width(2);//ÉèÖÃÎ»¿í
			cout<<day<<endl;
		}
};


class PID {
	private:
		int type;
		string idno;
		Date* bir;
	public:
		PID() {
		}

		PID(int tp,string n,string y,string m,string d):type(tp),idno(n) {
//			if(bir) {
//				delete[]bir;
//			}
			this->bir = new Date(y,m,d);
		}

		Date* getBir() {
			return this->bir;
		}

		void echo() {
//type=2 birth=1991.02.03
//ID=123456199102030006

			cout<<"type="<<type<<" birth=";
			bir->echo();
			cout<<"ID="<<idno<<endl;
		}

		void upgrade() {
			int len = idno.length();
			if(len == 15) {
				type = 2;

				string y2;
				y2.assign(bir->year,0,2);
				idno.insert(6,y2);

				int sum = 0;
				for(int i=0; i<17; i++) {
					sum += (idno[i]-'0');
				}
				sum = sum%10;
				string last;
				if(sum == 0) {
					last = "X";
				} else {
					last = '0'+sum;
				}
				idno.insert(17,last);
			}

			return;

		}
};

int main() {
	int t;
	int type;
	string y,m,d;
	string idno;

	cin>>t;
	while(t--) {
		cin>>type>>idno>>y>>m>>d;
		PID* pid = new PID(type,idno,y,m,d);
		pid->upgrade();
		pid->echo();


	}
//	delete []pid->getBir();
//	delete []pid;
	return 0 ;
}

