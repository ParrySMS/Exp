#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;

class CN; //��ǰ����
class EN; //��ǰ����
class Weight { //������
	protected:
		char kind[20]; //��������
		int gram; //��
	public:
		char* getKind() {
			return kind;
		}
		Weight() {	}
		Weight (char tk[], int tg=0) {
			strcpy(kind, tk);
			gram = tg;
		}
		virtual void Print(ostream & out) = 0; //�����ͬ���͵ļ�����Ϣ
};

class EN: public Weight { //Ӣ������
		int pound,oz,dram;

	public:
		EN() {};
		EN(int p,int o,int d,int g,char tk[] ) {
			strcpy(kind, tk);
			gram = g;
			pound = p;
			oz = o;
			dram = d;
		};

		int countGram() {
			return pound*512 +oz*32+dram*2+gram;
		}
		void Convert(int g) {
			if(g>=512) {
				pound = g/512;
				g=g-pound*512;
			}

			if(g>=32) {
				oz = g/32;
				g=g-oz*32;
			}

			if(g>=2) {
				dram = g/2;
				g=g-dram*2;
			}
			gram = g;
		}

		void Print(ostream & cout) {
			cout<<kind<<":";
			cout<<pound<<"��";
			cout<<oz<<"��˾";
			cout<<dram<<"����";
			cout<<gram<<"��"<<endl;
		}


};
class CN: public Weight { //�й�����
		int jin,liang,qian;

	public:
		CN() {};
		CN(int j,int l,int q,int g,char tk[] ) {
			strcpy(kind, tk);
			gram = g;
			jin = j;
			liang = l;
			qian = q;
		};

		void Convert(int g) {
			if(g>=500) {
				jin = g/500;
				g=g-jin*500;
			}

			if(g>=50) {
				liang = g/50;
				g=g-liang*50;
			}

			if(g>=5) {
				qian = g/5;
				g=g-qian*5;
			}
			gram = g;
		}

		void Print(ostream & cout) {
			cout<<kind<<":";
			cout<<jin<<"��";
			cout<<liang<<"��";
			cout<<qian<<"Ǯ";
			cout<<gram<<"��"<<endl;
		}

		void operator=(EN & en) {
			int g = en.countGram();
			Convert(g);
		}


};

//��ȫ�ֺ�����ʽ������������������3-5��....���б�д
void operator<<( ostream & os,Weight & w) {
	w.Print(os);
}


//���غ�����������������ostream������Weight����󣬲��������Ƕ�����������
//���غ���������ò���Weight�����Print����
int main() { //������
	int tw;
//����һ���й����������cn
//���������Ӧ�����Ǯ���ˡ����ͣ����п˺������Ƕ�Ӧ��������gram��kind
	char c1[] ="�й�����";
	CN cn(0,0,0,0, c1);
	cin>>tw;
	cn.Convert(tw); //������Ŀ���ת���й�����
	cout<<cn;

//����Ӣ�����������en
//���������Ӧ������˾���������ˡ����ͣ����п˺������Ƕ�Ӧ��������gram��kind
	char c2[] ="Ӣ������";
	EN en(0,0,0,0,c2);
	cin>>tw;
	en.Convert(tw); //������Ŀ���ת��Ӣ������
	cout<<en;
	cn=en; //��Ӣ������ת���й�����
	cout<<cn;
	return 0;
}
