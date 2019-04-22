#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class TV {
	private:
		string state,mode,input;
		int volume,maxc,channel;
	public:
		friend class TVCtrl;
		TV() {}
		TV(string s,int mc = 100,string _mode = "Cable")
			:state(s),maxc(mc),mode(_mode) {}

		TV(string s,int _volume,int _channel,string _mode,string _input,int mc = 100)
			:state(s),volume(_volume),maxc(mc),channel(_channel),mode(_mode),input(_input) {}

		void init(string s,int mc = 100) {
			state.clear();
			state = s;
			maxc = mc;
		}
		bool isOn() {
			return (state == "on");
		}

		void onoff() {
			if(isOn()) {
				state.clear();
				state = "off";
			} else {
				state.clear();
				state = "on";
			}
		}



		void volUp() {
			if(isOn())
				volume++;
		}

		void volDw() {
			if(isOn())	volume--;
		}

		void chUp() {
			if(isOn())	channel++;
		}

		void chDw() {
			if(isOn())	channel--;
		}

		void changeMode() {
			if(isOn()) {
				if(mode == "Cable") {
					mode.clear();
					mode = "Antenna";
				} else {
					mode.clear();
					mode = "Cable";
				}
			}
		}

		void changeInput() {
			if(isOn()) {
				if(input == "VCR") {
					input.clear();
					input = "TV";
				} else {
					input.clear();
					input = "VCR";
				}
			}
		}

		void echoSettings() {
			cout<<state<<" "<<volume<<" "<<channel<<" "<<mode<<" "<<input;
		}
};


class TVCtrl {
	private:
		string mode;
	public:
		TVCtrl() { }
		TVCtrl(string _mode):mode(_mode) {}
		void volUp(TV &t) {
			return t.volUp();
		}
		void volDw(TV &t) {
			return t.volDw();
		}

		void onoff(TV &t) {
			return t.onoff();
		}

		void chUp(TV &t) {
			return t.chUp();
		}

		void chDw(TV &t) {
			return t.chDw();
		}

		void setChan(TV &t,int chan) {
			t.channel = chan;
		}

		void setMode(TV &t) {
			return t.changeMode();
		}

		void setInput(TV &t) {
			return t.changeInput();
		}

};
int main() {
	string state,mode,input;
	int channel;
	int volume,maxc;
	cin>>state>>volume>>channel>>mode>>input;
	TV t(state,volume,channel,mode,input);
	TVCtrl ctrl(mode);
	string op;
	int num = 5;
	while(num--) {
		cin>>op;
		if(op == "onoff") {
			ctrl.onoff(t);
			continue;
		}

		if(op == "volup") {
			ctrl.volUp(t);
			continue;
		}
		if(op == "voldowm") {
			ctrl.volDw(t);
			continue;
		}
		if(op == "chanup") {
			ctrl.chUp(t);
			continue;
		}
		if(op == "chandown") {
			ctrl.chDw(t);
			continue;
		}
		if(op == "set_mode") {
			ctrl.setMode(t);
			continue;
		}
		if(op == "set_input") {
			ctrl.setInput(t);
			continue;
		}
	}
	t.echoSettings();
	return 0 ;
}

