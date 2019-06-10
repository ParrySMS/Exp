#include <iostream>
#include <math.h>
#include <cstring>
#include <iomanip>
using namespace std;
class CPoint {
	private:
		int	x,y;//point 2 y upper
	public:
		CPoint() {}
		CPoint(CPoint &c) {
			x = c.getX();
			y = c.getY();
		}

		CPoint(int _x,int _y)
			:x(_x),y(_y) {

		}

		void init(CPoint &c) {
			x = c.getX();
			y = c.getY();
		}

		void init(int _x,int _y) {
			x = _x;
			y = _y;
		}

		int getX() {
			return x;
		}

		int getY() {
			return y;
		}
};

class CRect {
	public:
		CPoint leftPoint,rightPoint;
		CRect() {}
		CRect(CPoint &cp1,CPoint &cp2) {
			if(cp1.getX()<cp2.getX()) {
				leftPoint.init(cp1);
				rightPoint.init(cp2);
			} else {
				leftPoint.init(cp2);
				rightPoint.init(cp1);
			}
		}

		bool operator>(CPoint & cp) {
			return (
			           cp.getX()>=leftPoint.getX()
			           && cp.getX()<=rightPoint.getX()
			           && cp.getY()<=leftPoint.getY()
			           && cp.getY()>=rightPoint.getY()
			       );
		}

		bool operator>(CRect & cr) {
			return (
			           (*this)>cr.leftPoint && (*this)>cr.rightPoint
			       );
		}

		bool operator==(CRect & cr) {
			return (
			           (*this)>cr && cr>(*this)
			       );
		}

		bool operator*(CRect & cr) {
			return !(
						cr.rightPoint.getY() > this->leftPoint.getY() 
						||  cr.leftPoint.getY() < this->rightPoint.getY() 
						|| cr.rightPoint.getX() < this->leftPoint.getX() 
			          	|| cr.leftPoint.getX() > this->rightPoint.getX()
			          	
			       );
		}

		operator int() {
			int dx = rightPoint.getX()-leftPoint.getX();
			int dy =  rightPoint.getY()-leftPoint.getY();
			return abs(dx*dy);
		}

		friend ostream & operator<<(ostream & o,CRect& cr);
};

ostream & operator<<(ostream & o,CRect& cr) {
//	1 4 4 1
	o<<cr.leftPoint.getX()<<" ";
	o<<cr.leftPoint.getY()<<" ";
	o<<cr.rightPoint.getX()<<" ";
	o<<cr.rightPoint.getY();

}

int main() {
	int t,x1,x2,y1,y2;
	cin>>t;

	while(t--) {
		cin>>x1>>y1>>x2>>y2;
		CPoint p1(x1,y1);
		CPoint p2(x2,y2);
		CRect r1(p1,p2);

		cin>>x1>>y1>>x2>>y2;
		p1.init(x1,y1);
		p2.init(x2,y2);
		CRect r2(p1,p2);

		cout<<"矩形1:"<<r1<<" "<<(int)r1<<endl;
		cout<<"矩形2:"<<r2<<" "<<(int)r2<<endl;
		if (r1==r2)
			cout<<"矩形1和矩形2相等"<<endl;
		else if(r2>r1)
			cout<<"矩形2包含矩形1"<<endl;
		else if(r1>r2)
			cout<<"矩形1包含矩形2"<<endl;
		else if(r1*r2)
			cout<<"矩形1和矩形2相交"<<endl;
		else
			cout<<"矩形1和矩形2不相交"<<endl;

		cout<<endl;
	}

	return 0 ;
}

