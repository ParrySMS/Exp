#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;


class CDate {
	private:
		string name;
		int year, month, day;
	public:
		CDate() {}
		CDate(string n,int y, int m, int d) {
			name = n;
			year = y;
			month = m;
			day = d;
		}
		void init(string n,int y, int m, int d) {
			name = n;
			year = y;
			month = m;
			day = d;
		}
		bool isLeapYear(int y) {
			return (y%4 == 0 && y%100 != 0) || y%400 == 0;
		}
		bool isLeapYear() {
			return (year%4 == 0 && year%100 != 0) || year%400 == 0;
		}
		string getName() {
			return name;
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

		int getDay2Year() {
			int sum = 0;
			for(int i=1990; i<year; i++) {
				if (isLeapYear(i)) {
					sum++;
				}
			}
			sum +=  365*(year-1990);
			return sum;

		}
};
int operator-(CDate& a,CDate& b) {
	int daya = a.getDay2Year() + a.getDayofYear();
	int dayb = b.getDay2Year()+b.getDayofYear();
	return abs(daya - dayb);
}

int main() {
	int i,j,t;
	string name;
	int year, month, day;
	cin>>t;
	CDate * cd = new CDate[t];
	for(i=0; i<t; i++) {
		cin>>name>>year>>month>>day;
		cd[i].init(name,year,month,day);
	}

	int maxi,maxj,max=0;
	for(i=0; i<t; i++) {
		for(j=0; j<t; j++) {

			if(i==j) continue;

			if(max < cd[i]-cd[j]) {
				max = cd[i]-cd[j];
				maxi = i;
				maxj = j;
			}
		}
	}


	cout<<cd[maxi].getName()<<"和"<<cd[maxj].getName()<<"年龄相差最大，为"<<max<<"天。"<<endl;

	return 0 ;
}

