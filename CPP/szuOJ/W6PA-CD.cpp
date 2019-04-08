#include <iostream>
#include <cstring>
#include <algorithm>
#include <math.h>
#include <iomanip>
using namespace std;

class CD {
	public:
		int type;//1-�ڽ�Ƭ��2-CD��3-VCD��4-DVD
		string name;
		int rental;//ÿ�����۸�
		int state;//0��δ���⣬1���ѳ���

		CD() {};
		CD(int type,string name,int rental,int state)
			:type(type),name(name),rental(rental),state(state) {
		};

		void check() {

			switch(type) {
				case 1:
					cout<<"�ڽ�Ƭ";
					break;
				case 2:
					cout<<"CD";
					break;
				case 3:
					cout<<"VCD";
					break;
				case 4:
					cout<<"DVD";
					break;
			}

			cout<<"["<<name<<"]";
			string is_rent = (state)?"�ѳ���":"δ����";
			cout<<is_rent<<endl;
		}

		void getRental(int day) {
			int money = day*rental;
			if(state) {
				cout<<"��ǰ���Ϊ"<<money<<endl;
			} else {
				cout<<"δ�������"<<endl;
			}
		}



};


int main() {
	int i,n;
	int type;//1-�ڽ�Ƭ��2-CD��3-VCD��4-DVD
	string name;
	int rental;//ÿ�����۸�
	int state;//0��δ���⣬1���ѳ���
	int op_code;
	cin>>n;


	for(i=0; i<n; i++) {
		cin>>type>>name>>rental>>state>>op_code;
		CD cd(type,name,rental,state);
		switch(op_code) {
			case 0: //��ʾ��ѯ����
				cd.check();
				break;
			default: //��0���ʾ��ѯ���Ҽ���������
				cd.check();
				cd.getRental(op_code);

		}

	}

	return 0;
}

