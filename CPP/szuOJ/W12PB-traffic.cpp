#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class CVehicle {

	protected:
		int max_speed;
		int speed;
		int weight;


	public:
		CVehicle() {}
		CVehicle(int ms,int v,int w) {
			max_speed = ms;
			speed = v;
			weight = w;
		}

		void init(int ms,int v,int w) {
			max_speed = ms;
			speed = v;
			weight = w;
		}

		void display(string title = "Vehicle") {
			cout<<title<<":"<<endl;
			cout<<"max_speed:"<<max_speed<<endl;
			cout<<"speed:"<<speed<<endl;
			cout<<"weight:"<<weight<<endl;
		}

		int getMS() {
			return max_speed;
		}

		int getV() {
			return speed;
		}

		int getWeight() {
			return weight;
		}

};


class CBicycle : virtual public CVehicle {

	protected:
		int height;

	public:
		CBicycle() {}


		CBicycle(int h) {
			height = h;
		}

		CBicycle(CVehicle &cv,int h)
			:CVehicle(cv.getMS(),cv.getV(),cv.getWeight()) {
			height = h;
		}

		void showBYC(string title = "Bicycle") {
			cout<<endl;
			this->display(title);
			cout<<"height:"<<height<<endl;
		}
};

class CMotocar: virtual public CVehicle {
	protected:
		int seat_num;
		string job;

	public:
		CMotocar() {}


		CMotocar(int n) {
			seat_num = n;
		}

		CMotocar(CVehicle &cv,int n)
			:CVehicle(cv.getMS(),cv.getV(),cv.getWeight()) {
			seat_num = n;
		}

		void showMOT(string title = "Motocar") {
			cout<<endl;
			this->display(title);
			cout<<"seat_num:"<<seat_num<<endl;
		}

};

class CMotocycle:public CBicycle,public CMotocar {
	protected:

	public:
		CMotocycle() { }

		CMotocycle(int ms,int v,int w,int h,int n)
			:CVehicle(ms,v,w),
			 CBicycle(h),
			 CMotocar(n) {

		}


		void showMC(string title = "Motocycle") {
			this->showBYC(title);
			cout<<"seat_num:"<<seat_num<<endl;
		}

};

int main() {
	int max_speed;
	int speed;
	int weight;
	int height;
	int seat_num;

	cin>>max_speed>>speed>>weight;

	CVehicle cv(max_speed,speed,weight);
	cv.display();

	cin>>height;
	CBicycle cb(cv,height);
	cb.showBYC();
	
	cin>>seat_num;
	CMotocar cm(cv,seat_num);
	cm.showMOT();
	
	CMotocycle cmoc(max_speed,speed,weight,height,seat_num);
	cmoc.showMC();
	
	
	return 0 ;
}


