#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;


class TV {
	private:
		int tvid;
		string mode_str;
		int chanel;
		int vol;
	public:
		friend class TVCtrl;
		string getModeStr() {
			return mode_str;
		}

		TV() {};

		TV(int _tvid,int _chanel,string _mode_str ="TV",int _vol=50)
			:tvid(_tvid),mode_str(_mode_str),vol(_vol),	chanel(_chanel) {

		}

		void init(int _tvid,int _chanel,string _mode_str ="TV",int _vol=50) {
			tvid = _tvid;
			mode_str =_mode_str;
			chanel = _chanel;
			vol = _vol;
		}

		void init(int mode,int _chanel,int vol_change) {
			mode_str = mode == 1 ? "TV": "DVD";
			chanel = mode == 1? _chanel:99;
			vol = vol + vol_change;
			if(vol<0) {
				vol =0;
			}

			if(vol>100) {
				vol = 100;
			}

		}

		void echo() {
//			第3号电视机--TV模式--频道11--音量70
			int echo_id = tvid+1;
			cout<<"第"<<tvid<<"号电视机";
			cout<<"--"<<mode_str<<"模式";
			cout<<"--频道"<<chanel;
			cout<<"--音量"<<vol<<endl;
		}

};

class TVCtrl {
	public:
		TVCtrl() { }
//		TVCtrl(string _mode):mode(_mode) {}

		void ctrl(TV &t,int mode,int _chanel,int vol_change) {
			return t.init( mode, _chanel, vol_change);
		}

		void init(TV* tvs,int size) {
			int i;
			for(i=0; i<size; i++) {
				tvs[i].init(i,i);
			}
		}

		void echo(TV &t) {
			t.echo();
		}

		void sum(TV* tvs,int size) {
			int i,sum_tv=0,sum_dvd=0;
			for(i=0; i<size; i++) {

				if(tvs[i].getModeStr()=="TV") {
					sum_tv++;
				} else {
					sum_dvd++;
				}
			}

			cout<<"播放电视的电视机数量为"<<sum_tv<<endl;
			cout<<"播放DVD的电视机数量为"<<sum_dvd<<endl;
		}

};

int main() {
	int n,i,t;
	cin>>n>>t;
	TV* tvs = new TV[n];
	TVCtrl  tvc;
	tvc.init(tvs,n);

	int tvid,mode,chanel,vol_change;
	for(i=0; i<t; i++) {
		cin>>tvid>>mode>>chanel>>vol_change;
		tvc.ctrl(*(tvs+tvid),mode,chanel,vol_change);
		tvc.echo(*(tvs+tvid));
	}
	tvc.sum(tvs,n);

	delete []tvs;

	return 0 ;
}


