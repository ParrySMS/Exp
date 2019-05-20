#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class CVIP	{
	protected:
		int card_id;
		int point;

	public:
		CCard() {}
		CCard(int c,int p) {
			card_id = c;
			point = p;
		}

		void init(int c,int p) {
			card_id = c;
			point = p;
		}

};

class CCredit {
	protected:
		int credit_id;
		string name;
		int max;
		double bill;
		int cpoint;

	public:
		CCredit() {	}
		CCredit(int cid,string _name,int _max,double _bill,int _cpoint) {
			credit_id = cid;
			name = _name;
			max = _max;
			bill = _bill;
			cpoint = _cpoint;
		}
};


class CCreditVIP:  public CCredit,public CVIP  {

	public:
		CCreditVIP() {}


		CCreditVIP(int n) {
			seat_num = n;
		}


};

int main() {
	int card_id;
	int point;
	int credit_id;
	string name;
	int max;
	double bill;
	int cpoint;

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


