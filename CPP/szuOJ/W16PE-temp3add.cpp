#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;

template <class T>

class CTime {
	private:
		int h,m,s;
	public:
		CTime() {}
		CTime(int hour,int min,int sec):h(hour),m(min),s(sec) {}
		void init(int hour,int min,int sec) {
			h = hour;
			m = min;
			s = sec;
		}

		int getH() {
			return h;
		}

		int getM() {
			return m;
		}

		int getS() {
			return s;
		}
		void addS(int sec) {
			s += sec;

			if(s>=60) {
				int addm = s/60;
				s = s%60;
				m +=addm;
			}

			if(m>=60) {
				int addh = m/60;
				m = m%60;
				h +=addh;
			}

			if(h>=12) {
				h=h%12;
			}
			//--------------sub
			if(s<0) {
				s = -1*s;
				int subm = 1+s/60;
				s = 60 -s%60;
				m -=subm;
			}

			if(m<0) {
				m = -1*m;
				int subh = 1+m/60;
				m = 60 -m%60;
				h -=subh;
			}

			if(h<0) {
				h = -1*h;
				h = 12-h%12;
			}

		}

		void show() {
			cout<<h<<" "<<m<<" "<<s<<endl;
		}

};
int main() {


	return 0 ;
}


