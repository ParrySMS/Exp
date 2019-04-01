#include <iostream>
#include <math.h>
#include <iomanip>
using namespace std;
class Point {
		int x = 0;
		int y = 0;
	public:
		Point() {};
		Point(int x,int y) {
			this->x = x;
			this->y = y;
		}
		void output() {
			cout<<"point "<<x<<" "<<y<<endl;
		}
};
int main() {
	Point p0;
	p0.output();

	Point *p_p1 = new Point(1,1);
	p_p1->output();
	(*p_p1).output();

	Point p2(2,2);
	Point *p_p2 = &p2;
	p_p2->output();
	(*p_p2).output();
	p2.output();





	return 0;
}
