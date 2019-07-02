#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;

template <class T>
class Cryption {
		T ptxt[100];	//����
		T ctxt[100];	//����
		T key;	//��Կ
		int len;	//����

	public:
		Cryption(T& tk, T tt[], int tl) { //�������ζ�Ӧ��Կ�����ġ�����
			int i;	
			key = tk;
			len = tl;
			for(i=0; i<len; i++) {
				ptxt[i] = tt[i];
			}
		}

		void Encrypt() { //����
			T max;
			int i,j;
			for(i=0; i<len; i++) {
				if(i==0||ptxt[i]>max) {
					max = ptxt[i];
				}
			}

			for(i=0; i<len; i++) {
				ctxt[i] = key + max - ptxt[i];
			}

		}

		void Print() { //��ӡ���������
			int i;
			for (i=0; i<len-1; i++)
				cout<<ctxt[i]<<" ";
			cout<<ctxt[i]<<endl;
		}
};
//֧���������͵�������
int main() {
	int i;
	int length; //����
	int ik, itxt[100];
	double dk, dtxt[100];
	char ck, ctxt[100];
	//��������
	cin>>ik>>length;
	for (i=0; i<length; i++)
		cin>>itxt[i];
	Cryption<int> ic(ik, itxt, length);
	ic.Encrypt();
	ic.Print();
	//����������
	cin>>dk>>length;
	for (i=0; i<length; i++)
		cin>>dtxt[i];
	Cryption<double> dc(dk, dtxt, length);
	dc.Encrypt();
	dc.Print();
	//�ַ�����
	cin>>ck>>length;
	for (i=0; i<length; i++)
		cin>>ctxt[i];
	Cryption<char> cc(ck, ctxt, length);
	cc.Encrypt();
	cc.Print();

	return 0;
}
