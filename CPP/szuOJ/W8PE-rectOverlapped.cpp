#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;

class CPoint {
	private:
		int	x1,y1,x2,y2;//point 2 y upper
	public:
		CPoint() {}
		CPoint(CPoint &c) {
			x1 = c.getX1();
			y1 = c.getY1();
			x2 = c.getX2();
			y2 = c.getY2();
		}

		CPoint(int _x1,int _y1,int _x2,int _y2)
			:x1(_x1),x2(_x2),y1(_y1),y2(_y2) {
			if(y2<y1) {
				x2 = _x1;
				y2 = _y1;
				x1 = _x2;
				y1 = _y2;
			}
		}

		void init(int _x1,int _y1,int _x2,int _y2) {
			if(y2<y1) {
				x2 = _x1;
				y2 = _y1;
				x1 = _x2;
				y1 = _y2;
			} else {
				x2 = _x2;
				y2 = _y2;
				x1 = _x1;
				y1 = _y1;
			}
		}

		void init(CPoint &c) {
			x1 = c.getX1();
			y1 = c.getY1();
			x2 = c.getX2();
			y2 = c.getY2();
		}

		int getX1() {
			return x1;
		}
		int getX2() {
			return x2;
		}
		int getY1() {
			return y1;
		}
		int getY2() {
			return y2;
		}
};

class CRect {
	public:
		CPoint Top1,Top2;
		CRect() {}
		CRect(CPoint &cp1,CPoint &cp2) {
			int top_1,top_2;
			if(cp1.getY2() > cp2.getY2()) { //ymax compare
				Top1.init(cp1);
				Top2.init(cp2);
			} else {
				Top1.init(cp2);
				Top2.init(cp1);
			}

		}

		friend bool isOverlapped(CRect &r);
};

bool isOverlapped(CRect &r) {
	int xmin,xmax,ymin,ymax; //choose Top1 as mid rect,check around

	ymin = r.Top1.getY1();
	ymax = r.Top1.getY2();
	if(r.Top1.getX1() > r.Top1.getX2()) {
		xmax = r.Top1.getX1();
		xmin = r.Top1.getX2();
	} else {
		xmax = r.Top1.getX2();
		xmin = r.Top1.getX1();
	}

	//check up -- no need to do, Top1 higher

	//check down
	if(r.Top2.getY2()<ymin) {
		return false;
	}

	//check mid-rect right side xmax
	int left_x = r.Top2.getX1()<r.Top2.getX2()?r.Top2.getX1():r.Top2.getX2();
	if(xmax<left_x) {
		return false;
	}

	//check left side xmin
	int right_x = r.Top2.getX1()>r.Top2.getX2()?r.Top2.getX1():r.Top2.getX2();
	if(right_x<xmin) {
		return false;
	}

	//else
	return true;
}

int main() {
	int t;
	int x1, y1, x2, y2;
	cin>>t;
	while(t--) {
		cin>>x1>>y1>>x2>>y2;
		CPoint cp1(x1,y1,x2,y2);
		cin>>x1>>y1>>x2>>y2;
		CPoint cp2(x1,y1,x2,y2);
		CRect rec(cp1,cp2);

		if(!isOverlapped(rec)) {
			cout<<"not ";
		}
		cout<<"overlapped"<<endl;
	}

	return 0 ;
}

