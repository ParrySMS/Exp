#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
#include <bits/stdc++.h>
using namespace std;

class CDate {
	public:
		int year,month,day;
		CDate() {}
		CDate(int y,int m,int d) {
			year = y;
			month = m;
			day = d;
		}

		CDate(string date) {
			int total_num;
			stringstream ss; //������
			ss<<date;
			ss>>total_num;

			day = total_num%100;
			total_num /= 100;

			month = total_num%100;
			total_num /= 100;

			year = total_num;
		}

		void operator =(int total_num) {
			day = total_num%100;
			total_num /= 100;

			month = total_num%100;
			total_num /= 100;
			year = total_num;
		}

		operator int() {
			return year*10000+month*100+day;
		}




		void Print() {
//			2017��06��30��
			cout<<year<<"��";
			cout.fill('0');
			cout.width(2);
			cout<<month<<"��";
			cout.fill('0');
			cout.width(2);
			cout<<day<<"��"<<endl;

		}

};
int main() {
	int t, t1, t2;
	CDate C1, C2;
	cin>>t;
	while (t--) {
		cin>>t1>>t2;
		C1 = t1;
		C2 = t2;
		((C1>C2)?C1:C2).Print(); //���ڴ��������ڴ���C1>C2�У����Զ���C1��C2ת��Ϊ�������бȽ�
	}
	return 0;
}

