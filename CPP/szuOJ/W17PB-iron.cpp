#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class Iron {
		int hard,weight,vol;
	public:
		Iron() {	}
		Iron(int h,int w,int v) {
			hard = h;
			weight = w;
			vol = v;
		}
		void init(int h,int w,int v) {
			hard = h;
			weight = w;
			vol = v;
		}

		int getH() {
			return hard;
		}

		int getW() {
			return weight;
		}

		int getV() {
			return vol;
		}

		Iron operator ++() {
			hard++;
			weight = (int)(weight*1.1);
			vol = (int)(vol*1.1);
		}

		Iron operator --(int) {
			hard--;
			weight = (int)(weight*0.9);
			vol = (int)(vol*0.9);
		}

		Iron friend operator +(Iron& i1,Iron& i2) {
			int h = i1.getH()+i2.getH();
			int w = i1.getW()+i2.getW();
			int v = i1.getV()+i2.getV();
			i1.init(h,w,v);
			return i1;
		}

		Iron friend operator *(Iron& i1,int n) {
			int h = i1.getH();
			int w = i1.getW();
			int v = i1.getV()*n;
			i1.init(h,w,v);
			return i1;
		}

		void echo() {
//			硬度8--重量8000--体积800
			cout<<"硬度"<<hard<<"--";
			cout<<"重量"<<weight<<"--";
			cout<<"体积"<<vol<<endl;
		}

};
int main() {
	int hard,weight,vol,n;

	cin>>hard>>weight>>vol;
	Iron i1 = Iron(hard,weight,vol);
	Iron i1_t = Iron(hard,weight,vol);

	cin>>hard>>weight>>vol;
	Iron i2 = Iron(hard,weight,vol);
	Iron i2_t = Iron(hard,weight,vol);

	cin>>n;

	i1_t = i1_t+i2_t;
	i1_t.echo();

	i1_t.init(i1.getH(),i1.getW(),i1.getV());
	i1_t = i1_t*n;
	i1_t.echo();

	i1_t.init(i1.getH(),i1.getW(),i1.getV());
	++i1_t;
	i1_t.echo();

	i2_t--;
	i2_t.echo();


	return 0 ;
}

