#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class CTime{
private:
	int h,m,s;
public:
	CTime(){}
	CTime(int hour,int min,int sec):h(hour),m(min),s(sec){}
	void init(int hour,int min,int sec){
		h = hour;
		m = min;
		s = sec;
	}

	int getH(){
		return h;
	}

	int getM(){
		return m;
	}

	int getS(){
		return s;
	}
};
class CDate {
	private:
		int y,m,d;
	public:
		CDate() {
			this->y = 1900;
			this->m = 1;
			this->d = 1;
		}

		CDate(int y,int m,int d) {
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

};

void display(CDate & d, CTime & t){
	cout<<d.getY()<<"-";

	cout.fill('0');//设置填充字符
	cout.width(2);//设置位宽
	cout<<d.getM()<<"-"；

	cout.fill('0');//设置填充字符
	cout.width(2);//设置位宽
	cout<<d.getD()<<" ";

	cout.fill('0');//设置填充字符
	cout.width(2);//设置位宽
	cout<<t.getH()<<":";

	cout.fill('0');//设置填充字符
	cout.width(2);//设置位宽
	cout<<t.getM()<<":";

	cout.fill('0');//设置填充字符
	cout.width(2);//设置位宽
	cout<<t.getS()<<endl;
}

int main() {

	int i,t;
	int year,mon,day,hour,min,sec;
	cin>>t;
	while(t--){
		cin>>year>>mon>>day>>hour>>min>>sec;
		CDate cdate(year,mon,day);
		CTime ctime(hour,min,sec);
		display(cdate,ctime);
	}

	return 0 ;
}

