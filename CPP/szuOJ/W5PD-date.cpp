#include <iostream>
#include <math.h>
#include <iomanip>
using namespace std;

class Date {
		int y,m,d;
	public:
		Date() {
			this->y = 1900;
			this->m = 1;
			this->d = 1;
		}

		Date(int y,int m,int d) {
			this->y = y;
			this->m = m;
			this->d = d;
		}

		int getY() {
			return y;
		}
		int getM() {
			return m;
		}
		int getD() {
			return d;
		}

		void init(int y,int m,int d) {
			this->y = y;
			this->m = m;
			this->d = d;
		}

		void output() {
//Today is 2012/01/03
//Tomorrow is 2012/01/04
			cout<<setprecision(2);
			cout<<"Today is ";
			cout<<y<<"/";

			cout.fill('0');//ÉèÖÃÌî³ä×Ö·û
			cout.width(2);
			cout<<m<<"/";
			cout.width(2);
			cout<<d<<endl;

			addOneDay();

			cout<<"Tomorrow is ";
			cout<<y<<"/";
			cout.fill('0');//ÉèÖÃÌî³ä×Ö·û
			cout.width(2);
			cout<<m<<"/";
			cout.width(2);
			cout<<d<<endl;
		}

		void addOneDay() {
			d++;
			bool isR = ((y%4==0 && y%100!=0)||(y%400==0));
			int feb_day = isR ? 29:28;

			if(m==2 && d>feb_day) { //feb
				m++;
				d=1;
			}

			//other month
			switch (m) {
				case 1:
				case 3:
				case 5:
				case 7:
				case 8:
				case 10:
					if(d>31) {
						m++;
						d=1;
					}
					break;
				case 4:
				case 6:
				case 9:
				case 11:
					if(d>30) {
						m++;
						d=1;
					}
					break;
			}

			//dec
			if(m==12 &&d>31) {
				y++;
				m=1;
				d=1;
			}
		}
};


int main() {
	int t,i;
	int y,m,d;
	Date date;
	cin>>t;
	while(t--) {
		cin>>y>>m>>d;
		date.init(y,m,d);
		date.output();
	}

	return 0 ;
}
