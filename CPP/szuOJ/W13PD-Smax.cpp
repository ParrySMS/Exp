#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;

const double PI = 3.14;
class Geometry {
	public:
		double area;
		virtual void getArea()=0; //����������������С�������λ
		Geometry() {}
};

class Rect:public Geometry {
	protected:
		int a,b;
	public:
		Rect() {	}
		Rect(int _a,int _b) {
			a= _a;
			b= _b;
		}
		void init(int _a,int _b) {
			a= _a;
			b= _b;
		}

		void getArea() {
			area =  (double)a*b;
		}

};

class Circle:public Geometry {
	protected:
		int r;
	public:
		Circle() {	}
		Circle(int _r) {
			r = _r;
		}
		void init(int _r) {
			r = _r;
		}

		void getArea() {
			area = PI*r*r;
		}

};

class TotalArea {

	public:
		static void computerTotalArea(Geometry** t,int n) {
			int i;
			double max = 0;
			for(i=0; i<n; i++) {
				if(t[i]->area > max) {
					max = t[i]->area;
				}
			}
			cout<<setiosflags(ios::fixed) <<setprecision(2);
			cout<<"������="<<max<<endl;
		}
		//tΪ�������ָ�룬ָ��һ�����ද̬���飬
		//�����ÿ��Ԫ��ָ��һ������ͼ�Σ�nΪ����Ĵ�С
		TotalArea() {		}
};

int main() {
	int t,i,a,b,r;
	int type;
	cin>>t;
	Geometry** p_geo = new Geometry*[t];

	for(i=0; i<t; i++) {
		cin>>type;
		switch(type) {
			case 1 : //rect
				cin>>a>>b;
				p_geo[i] = new Rect(a,b);
				break;
			case 2 : //cir
				cin>>r;
				p_geo[i] = new Circle(r);
				break;
		}
		p_geo[i]->getArea();
	}

	TotalArea::computerTotalArea(p_geo,t);
	for(i=0; i<t; i++) {
		delete p_geo[i];
	}
	delete []p_geo;
	return 0 ;
}


