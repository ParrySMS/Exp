#include <iostream>
using namespace std;

class CDate {
	private:
		int year, month, day;
	public:
		CDate(int y, int m, int d) {
			year = y;
			month = m;
			day = d;
		}
		bool isLeapYear() {
			return (year%4 == 0 && year%100 != 0) || year%400 == 0;
		}
		int getYear() {
			return year;
		}
		int getMonth() {
			return month;
		}
		int getDay() {
			return day;
		}
		int getDayofYear() {       //计算日期从当年1月1日算起的天数
			int i, sum=day;
			int a[13]= {0,31,28,31,30,31,30,31,31,30,31,30,31};
			int b[13]= {0,31,29,31,30,31,30,31,31,30,31,30,31};

			if (isLeapYear())
				for(i=0; i<month; i++)   sum +=b[i];
			else
				for(i=0; i<month; i++)   sum +=a[i];

			return sum;
		}

		int getDay2Year(int y) {

			int sum = 0;
			for(int i=year; i<y; i++) {
				if (isLeapYear()) {
					sum++;
				}
			}

			sum +=  365*(y-year);

			return sum;

		}
};

class Sw {
	private:
		string name;
		string type;
		CDate* DDL;
		string media;
	public:
		void setTypeMedia(string type,string media) {
			if(type.compare("O")==0) {
				this->type = "original";
			} else if(type.compare("B")==0) {
				this->type = "backup";
			} else  if(type.compare("T")==0) {
				this->type = "trial";
			}

			if(media.compare("D")==0) {
				this->media = "optical disk";
			} else if(media.compare("H")==0) {
				this->media = "hard disk";
			} else  if(media.compare("U")==0) {
				this->media = "USB disk";
			}
		}


		Sw(string name,string type,string media,int y,int m,int d):name(name) {
			DDL = new CDate(y,m,d);
			if(type.compare("O")==0) {
				this->type = "original";
			} else if(type.compare("B")==0) {
				this->type = "backup";
			} else  if(type.compare("T")==0) {
				this->type = "trial";
			}

			if(media.compare("D")==0) {
				this->media = "optical disk";
			} else if(media.compare("H")==0) {
				this->media = "hard disk";
			} else  if(media.compare("U")==0) {
				this->media = "USB disk";
			}

		}

		~Sw() {
			if(DDL) {
				delete[] DDL;
			}
		}

		void echo() {
			cout<<"name:"<<name<<endl;
			cout<<"type:"<<type<<endl;
			cout<<"media:"<<media<<endl;
			check();
		}

		void check() {
			CDate* exp = new CDate(2015,4,7);

			if(DDL->getYear() == 0 && DDL->getMonth() == 0 && DDL->getDay() ==0) {
				cout<<"this software has unlimited use"<<endl;
			} else if(DDL->getYear() < 2015) {
				cout<<"this software has expired"<<endl;
			} else if(DDL->getYear() == 2015 && DDL->getDayofYear() <= exp->getDayofYear()) {
				cout<<"this software has expired"<<endl;
			} else if(DDL->getYear() == 2015 && DDL->getDayofYear() > exp->getDayofYear()) {
				int d = DDL->getDayofYear() - exp->getDayofYear();
				cout<<"this software is going to be expired in "<<d<<" days"<<endl;
			} else {
				int dy = exp->getDay2Year(DDL->getYear());
				int vaild = dy + DDL->getDayofYear() - exp->getDayofYear();
				cout<<"this software is going to be expired in "<<vaild<<" days"<<endl;
			}
		}


};

int main() {
	int t;
	string name,type,media;
	int y,m,d;

	cin>>t;
	while(t--) {
		cin>>name>>type>>media>>y>>m>>d;
		Sw* sw = new Sw(name,type,media,y,m,d);
		sw->echo();
		cout<<endl;
		sw->setTypeMedia("B","H");
		sw->echo();
		if(t>0) {
			cout<<endl;
		}
		delete sw;
	}
	return 0 ;
}

